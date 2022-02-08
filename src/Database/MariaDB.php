<?php

namespace DBS2\Database;

use DBS2\Configuration\Configuration;

class MariaDB extends AbstractDatabase
{
    /** @var \mysqli */
    private $dbResource;

    /** @var bool */
    private $isConnected;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->dbResource->close();
        $this->isConnected = false;
    }

    /**
     * @return $this
     */
    public function connect(): self
    {
        $config = new Configuration();
        $dbConfig = $config->getGlobalConfig()['db']['mariadb'];
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->dbResource = new \mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);
        $this->isConnected = false;
        if($this->dbResource->connect_errno)
        {
            throw new \RuntimeException('mysqli connection error: ' . $this->dbResource->connect_error);
            $this->dbResource = null;
            $this->isConnected = false;
        }
        return $this;
    }

    /**
     * @param string $queryStr
     */
    public function query(string $queryStr)
    {
        if($this->isConnected)
        {
            return $this->dbResource->query($queryStr);
        }
        return 0;
    }

    /**
     * @param null|\mysqli_result $queryResult
     * @return mixed|null
     */
    public function fetchArray($queryResult = null)
    {
        if($queryResult == null)
        {
            return null;
        }
        return $queryResult->fetch_array(MYSQLI_ASSOC);
    }
}