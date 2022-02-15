<?php

namespace DBS2\Database;

use DBS2\Configuration\Configuration;

class Postgresql extends AbstractDatabase
{
    /** @var resource */
    private $dbResource;

    /** @var bool */
    private $isConnected = false;

    /** @var string */
    private $queryStr = '';

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

    public function query()
    {
        if($this->isConnected && strlen($this->queryStr) > 0)
        {
            return pg_query($this->queryStr);
        }
        return 0;
    }

    public function fetchArray($queryResult = null)
    {
        return pg_fetch_array($queryResult, null, PGSQL_ASSOC);
    }

    /**
     * @return string
     */
    public function getQueryStr(): string
    {
        return $this->queryStr;
    }

    /**
     * @param array $fields Array of fiels to select - if $fields is an empty array -> select all (*)
     * @param string $table
     * @return $this
     */
    public function select(array $fields, string $table): self
    {
        $config = new Configuration();
        $dbConfig = $config->getGlobalConfig()['db'][$_SESSION['dbType']];
        $this->queryStr = 'SELECT ';
        if(count($fields) < 1)
        {
            $this->queryStr .= '* ';
        }
        else
        {
            foreach($fields as $field)
            {
                $this->queryStr .= $field . ', ';
            }
            // remove last ', '
            $this->queryStr = substr($this->queryStr, 0, -2);
        }
        $this->queryStr .= 'FROM ' . $dbConfig['schema'] . '.' . $table;
        return $this;
    }

    /**
     * @param string $where
     * @return $this
     */
    public function where(string $where): self
    {
        $this->queryStr = rtrim($this->queryStr);
        $this->queryStr .= ' WHERE ' . $where;
        return $this;
    }

    /**
     * @param string $limit
     * @return $this
     */
    public function limit(string $limit): self
    {
        $this->queryStr = rtrim($this->queryStr);
        $this->queryStr .= ' LIMIT ' . $limit;
        return $this;
    }

    /**
     * @param string $expression
     * @return $this
     */
    public function and(string $expression): self
    {
        $this->queryStr = rtrim($this->queryStr);
        $this->queryStr .= ' AND ' . $expression;
        return $this;
    }

    /**
     * @param string $expression
     * @return $this
     */
    public function or(string $expression): self
    {
        $this->queryStr = rtrim($this->queryStr);
        $this->queryStr .= ' OR ' . $expression;
        return $this;
    }
}