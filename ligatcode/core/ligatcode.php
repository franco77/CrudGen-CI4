<?php
// namespace CC;
use Dotenv\Dotenv as Dotenv;

class Ligatcode
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $sql;

    public function __construct()
    {
        $this->connection();
    }

    public function __destruct()
    {
        // Cerrar la conexión automáticamente cuando el objeto sea destruido
        if ($this->sql) {
            $this->sql->close();
        }
    }


    public function connection()
    {
        try {
            $filePath = __DIR__ . "/../../.env";
            $env = parse_ini_file($filePath);

            if (!$env || empty($env['database.default.hostname']) || empty($env['database.default.database']) || empty($env['database.default.username'])) {
                throw new \Exception("Las configuraciones de la base de datos en el archivo .env no están completas.");
            }

            $this->host = $env['database.default.hostname'];
            $this->user = $env['database.default.username'];
            $this->password = $env['database.default.password'] ?? ''; // Valor por defecto vacío
            $this->database = $env['database.default.database'];
            $this->port = $env['database.default.port'] ?? 3306; // Usar puerto por defecto si no está configurado

            $this->sql = new \mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

            if ($this->sql->connect_error) {
                throw new \Exception("Error en la conexión a la base de datos: " . $this->sql->connect_error);
            }

            $this->sql->set_charset("utf8mb4");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }



    public function table_list()
    {
        try {
            $fields = [];
            $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?";

            if ($stmt = $this->sql->prepare($query)) {
                $stmt->bind_param('s', $this->database);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $fields[] = ['table_name' => $row['TABLE_NAME']];
                }

                $stmt->close();
                return $fields;
            }

            throw new \Exception("Error preparing statement: " . $this->sql->error);
        } catch (\Exception $e) {
            throw new \Exception("Error en table_list: " . $e->getMessage());
        }
    }

    public function primary_field($table)
    {
        try {
            $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_KEY = 'PRI'";

            if ($stmt = $this->sql->prepare($query)) {
                $stmt->bind_param('ss', $this->database, $table);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                return $row ? $row['COLUMN_NAME'] : null;
            }

            throw new \Exception("Error preparing statement: " . $this->sql->error);
        } catch (\Exception $e) {
            throw new \Exception("Error en primary_field: " . $e->getMessage());
        }
    }

    public function not_primary_field($table)
    {
        try {
            $fields = [];
            $query = "SELECT 
    COLUMN_NAME, 
    COLUMN_KEY, 
    DATA_TYPE,
    COLUMN_TYPE, 
    CHARACTER_MAXIMUM_LENGTH AS MAX_LENGTH, 
    NUMERIC_PRECISION AS NUM_PRECISION, 
    NUMERIC_SCALE AS NUM_SCALE
FROM 
    INFORMATION_SCHEMA.COLUMNS
WHERE 
    TABLE_SCHEMA = ? 
    AND TABLE_NAME = ? 
    AND COLUMN_KEY <> 'PRI'";

            if ($stmt = $this->sql->prepare($query)) {
                $stmt->bind_param('ss', $this->database, $table);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $fields[] = [
                        'column_name' => $row['COLUMN_NAME'],
                        'column_key' => $row['COLUMN_KEY'],
                        'data_type' => $row['DATA_TYPE'],
                        'column_type' => $row['COLUMN_TYPE'],
                        'max_length' => $row['MAX_LENGTH'],
                    ];
                }

                $stmt->close();
                return $fields;
            }

            throw new \Exception("Error preparing statement: " . $this->sql->error);
        } catch (\Exception $e) {
            throw new \Exception("Error en not_primary_field: " . $e->getMessage());
        }
    }

    public function all_field($table)
    {
        try {
            $fields = [];
            $query = "SELECT COLUMN_NAME, COLUMN_KEY, DATA_TYPE 
                     FROM INFORMATION_SCHEMA.COLUMNS 
                     WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?";

            if ($stmt = $this->sql->prepare($query)) {
                $stmt->bind_param('ss', $this->database, $table);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $fields[] = [
                        'column_name' => $row['COLUMN_NAME'],
                        'column_key' => $row['COLUMN_KEY'],
                        'data_type' => $row['DATA_TYPE']
                    ];
                }

                $stmt->close();
                return $fields;
            }

            throw new \Exception("Error preparing statement: " . $this->sql->error);
        } catch (\Exception $e) {
            throw new \Exception("Error en all_field: " . $e->getMessage());
        }
    }
}
