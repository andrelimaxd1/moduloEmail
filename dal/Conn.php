<?php
// dal/Conn.php
namespace App\Dal;

use PDO;
use PDOException;
use Exception;

abstract class Conn {
    private static ?PDO $conn = null;
    private static string $host = "localhost";
    private static string $dbname = "moduloemail"; // ajuste para o nome real do banco
    private static string $user = "root";
    private static string $password = "";

    public static function getConn(): PDO {
    if (self::$conn === null) {
        try {
            
            self::$conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4",
                self::$user,
                self::$password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $e->getMessage(), 1);
        }
    }
    return self::$conn;
}
}