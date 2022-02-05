<?php

require_once(__DIR__ . '/../configuration.php');

class Database
{
    /** @var int */
    public const MARIADB = 1;
    /** @var int */
    public const POSTGRESQL = 2;

    /** @var int type of selected database */
    private $type = 0;

    /** @var mixed db connection resource */
    private $connection = null;

    /**
     * @param int $type
     */
    public function __construct(int $type = 0)
    {
        $this->type = $type;
        if($this->type != 0)
        {
            $this->connect();
        }
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /** connect to database */
    public function connect()
    {
        switch($this->type)
        {
            case self::$MARIADB:
                $this->connection = $this->connectMariadb();
                break;
            case self::$POSTGRESQL:
                $this->connection = $this->connectPostgresql();
                break;
            default:
                $this->connection = null;
                break;
        }
    }

    /**
     * @return mysqli|null
     */
    private function connectMariadb(): mysqli|null
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

    /**
     * @return resource
     */
    private function connectPostgresql()
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