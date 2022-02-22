<?php

namespace DBS2\Database;

use DBS2\Configuration\Configuration;
use DBS2\Debug\Logger;

class MariaDB extends AbstractDatabase
{
    /** @var \mysqli|null */
    private $dbResource = null;

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
        $this->dbResource->close();
        $this->isConnected = false;
    }

    /**
     * @return $this
     */
    public function connect(): self
    {
        $config = new Configuration();
        $dbConfig = $config->getGlobalConfig()['db'][$_SESSION['dbType']];
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->dbResource = new \mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);
        $this->isConnected = true;
        if($this->dbResource->connect_errno)
        {
            throw new \RuntimeException('mysqli connection error: ' . $this->dbResource->connect_error);
            $this->dbResource = null;
            $this->isConnected = false;
        }
        return $this;
    }

    public function query()
    {
        if($this->isConnected && strlen($this->queryStr) > 0)
        {
            return $this->dbResource->multi_query($this->queryStr);
        }
        return 0;
    }



    /**
     * @param null|\mysqli_result $queryResult
     * @return mixed|null
     */
    public function fetchArray($queryResult = null)
    {
        if($queryResult == null || $queryResult == false)
        {
            return null;
        }
        $resultArr = array();
        do
        {
            if($result = $this->dbResource->store_result())
            {
                while(true)
                {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if($row == null)
                    {
                        break;
                    }
                    $resultArr[] = $row;
                }
            }
        } while($this->dbResource->next_result());

        return $resultArr;
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
        $this->queryStr = 'SELECT ';
        if(count($fields) < 1)
        {
            $this->queryStr .= '*';
        }
        else
        {
            foreach($fields as $field)
            {
                $this->queryStr .= $field . ', ';
            }
            // remove last ', '
            $this->queryStr = substr($this->queryStr,0, -2);
        }
        $this->queryStr .= ' FROM ' . $table;
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