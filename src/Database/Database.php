<?php

namespace DBS2\Database;

class Database extends AbstractDatabase
{
    /** @var int */
    public const MARIADB = 1;
    /** @var int */
    public const POSTGRESQL = 2;

    /** @var int type of selected database */
    private $type = 0;
    /** @var MariaDB database ressource */
    private $dbRes = null;
    /** @var mixed */
    private $lastQueryResult = null;

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

    /**
     * connect to database
     * @return $this
     */
    public function connect(): self
    {
        switch($this->type)
        {
            case self::$MARIADB:
                $this->connection = new MariaDB();
                break;
            case self::$POSTGRESQL:
                $this->connection = new Postgresql();
                break;
            default:
                $this->connection = null;
                break;
        }
        return $this;
    }

    /**
     * @param string $queryStr
     */
    public function query(string $queryStr)
    {
        return $this->dbRes->query($queryStr);
    }

    /**
     * @param mixed $queryResult
     */
    public function fetchArray($queryResult = null)
    {
        if($queryResult == null && $this->lastQueryResult != null)
        {
            $queryResult = $this->lastQueryResult;
        }
        /** if both are null -> return an empty array */
        else
        {
            return array();
        }
        return $this->dbRes->fetchArray($queryResult);
    }
}