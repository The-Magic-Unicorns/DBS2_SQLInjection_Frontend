<?php

require_once(__DIR__ . '/../configuration.php');

class Database
{
    /** @var int */
    public const MARIADB = 1;
    /** @var int */
    public const POSTGRESQL = 2;

    /**
     * @param int $db_type
     */
    public function connect(int $db_type)
    {
        switch($db_type)
        {
            case self::$MARIADB:
                return $this->connect_mariadb();
                break;
            case self::$POSTGRESQL:
                return $this->connect_postgresql();
                break;
            default:
                return null;
                break;
        }
    }

    private function connect_mariadb()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $dbcon = new mysqli($CONFIG['db']['mariadb']['host'], $CONFIG['db']['mariadb']['user'], $CONFIG['db']['mariadb']['password'], $CONFIG['db']['mariadb']['dbname']);
        if($dbcon->connect_errno)
        {
            throw new RuntimeException('mysqli connection error: ' . $dbcon->connect_error);
            return null;
        }
        return $dbcon;
    }

    private function connect_postgresql()
    {
        $dbcon = pg_connect('host=' . $CONFIG['db']['psql']['host'] . ' '
            . 'dbname=' . $CONFIG['db']['psql']['dbname'] . ' '
            . 'user=' . $CONFIG['db']['psql']['user'] . ' '
            . 'password=' . $CONFIG['db']['psql']['password']);
        if(!$dbcon)
        {
            throw new RuntimeException('postgresql connection error: ' . pg_last_error());
            return null;
        }
        return $dbcon;
    }
}