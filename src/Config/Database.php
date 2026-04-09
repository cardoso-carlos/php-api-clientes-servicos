<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $driver = $_ENV['DB_DRIVER'] ?? getenv('DB_DRIVER') ?: 'sqlite';
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '1433';
        $database = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: '';

        $username = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: '';
        $password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';

        if ($database === '') {
            throw new RuntimeException('A variável DB_DATABASE não foi definida.');
        }

        try {
            $dsn = self::buildDsn($driver, $host, $port, $database);

            if ($driver === 'sqlite') {
                self::$connection = new PDO(
                    $dsn,
                    null,
                    null,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } else {
                self::$connection = new PDO(
                    $dsn,
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }

            return self::$connection;
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Erro ao conectar com o banco de dados: ' . $exception->getMessage(),
                (int) $exception->getCode(),
                $exception
            );
        }
    }

    private static function buildDsn(
        string $driver,
        string $host,
        string $port,
        string $database
    ): string {
        return match ($driver) {
            'sqlite' => self::buildSqliteDsn($database),
            'sqlsrv' => "sqlsrv:Server={$host},{$port};Database={$database}",
            'mysql' => "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
            'pgsql' => "pgsql:host={$host};port={$port};dbname={$database}",
            default => throw new RuntimeException("Driver de banco não suportado: {$driver}")
        };
    }

    private static function buildSqliteDsn(string $database): string {
        if ($database === '') {
            throw new RuntimeException('O caminho do banco SQLite não foi definido.');
        }

        if (str_starts_with($database, '/')) {
            return "sqlite:{$database}";
        }

        $basePath = dirname(__DIR__, 2);
        $fullPath = $basePath . DIRECTORY_SEPARATOR . $database;

        return "sqlite:{$fullPath}";
    }

    public static function closeConnection(): void {
        self::$connection = null;
    }
}