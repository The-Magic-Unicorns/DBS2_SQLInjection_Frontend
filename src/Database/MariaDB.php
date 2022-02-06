<?php

namespace DBS2\Database;

class MariaDB extends AbstractDatabase
{
    /** @var mysqli */
    private $dbResource;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return mysqli
     */
    public function connect()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $dbResource = new mysqli($CONFIG['db']['mariadb']['host'], $CONFIG['db']['mariadb']['user'], $CONFIG['db']['mariadb']['password'], $CONFIG['db']['mariadb']['dbname']);
        if($dbResource->connect_errno)
        {
            throw new RuntimeException('mysqli connection error: ' . $dbResource->connect_error);
            $this->dbResource = null;
        }
        $this->dbResource = $dbResource;
    }

    /**
     * @param string $queryStr
     */
    public function query(string $queryStr)
    {

    }

    public function fetchArray($queryResult = null)
    {

    }
}