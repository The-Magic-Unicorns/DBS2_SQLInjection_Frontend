<?php

namespace DBS2\Database;

use DBS2\Configuration\Configuration;

class Postgresql extends AbstractDatabase
{
    /** @var resource */
    private $dbResource;

    /** @var bool */
    private $isConnected;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        pg_close($this->dbResource);
        $this->isConnected = false;
    }

    /**
     * @return $this
     */
    public function connect(): self
    {
        $config = new Configuration();
        $dbConfig = $config->getGlobalConfig()['db']['psql'];
        $this->dbResource = pg_connect('host=' . $dbConfig['host'] . ' '
            . 'dbname=' . $dbConfig['dbname'] . ' '
            . 'user=' . $dbConfig['user'] . ' '
            . 'password=' . $dbConfig['password']);
        $this->isConnected = true;
        if(!$this->dbResource)
        {
            throw new RuntimeException('postgresql connection error: ' . pg_last_error());
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
        return pg_query($this->dbResource, $queryStr);
    }

    public function fetchArray($queryResult = null)
    {
        return pg_fetch_array($queryResult, null, PGSQL_ASSOC);
    }
}