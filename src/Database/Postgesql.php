<?php

namespace DBS2\Database;

class Postgresql extends AbstractDatabase
{
    /** @var mysqli */
    private $dbResource;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return resource
     */
    public function connect()
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