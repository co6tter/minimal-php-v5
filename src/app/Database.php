<?php

namespace MyApp;

class Database
{
    private static $instance;

    public static function getInstance(): \PDO
    {
        try {
            if (!isset(self::$instance)) {
                self::$instance = new \PDO(
                    DSN,
                    DB_USER,
                    DB_PASSWORD,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // PHP 8.0以降はデフォルト
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                        \PDO::ATTR_EMULATE_PREPARES => false // PHP 8.1以降の仕様変更によりエミュレート無効にしなくても型変換。セキュリティやSQL挙動の厳密さを求める場合は、依然としてfalseの明示が推奨。
                    ]
                );
            }

            return self::$instance;
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
            exit;
        }
    }
}
