<?php

class DatabaseConnection {
    private $host = "localhost:4306";
    private $username = "root";
    private $password = "";
    private $database = "jetdate";
    private $charset;
    private $pdo;

    public function __construct($host, $username, $password, $database, $charset = 'utf8') {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;

        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function query($sql, $params = []) {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public function closeConnection() {
        $this->pdo = null;
    }
}

?>
