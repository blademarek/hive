<?php

namespace Hive5;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use mysqli;
use mysqli_sql_exception;

class Database
{
    private static ?Database $instance = null;
    private mysqli $connection;
    private mixed $config;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . '/../config/database.json'));

        try {
            $this->connection = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->dbName, $this->config?->port);
        } catch (mysqli_sql_exception $e) {
            $this->error('DB connection error: ' . $e->getMessage());
        }

        $this->connection->set_charset('utf8');
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $query, $params = []): object|false|null
    {
        try {
            $stmt = $this->connection->prepare($query);

            if (!empty($params)) {
                // Bind parameters if there are any
                $paramTypes = str_repeat('s', count($params)); // Assuming all parameters are strings
                $stmt->bind_param($paramTypes, ...$params);
            }

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $stmt->close();
            } else {
                $stmt->close();
                return null;
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        return $result->fetch_object();
    }


    #[NoReturn] private function error(string $error): void
    {
        exit($error);
    }
}