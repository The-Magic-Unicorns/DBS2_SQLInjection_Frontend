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
    /** @var MariaDB|Postgresql database ressource */
    private $dbResource = null;
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
            case self::MARIADB:
                $this->dbResource = new MariaDB();
                break;
            case self::POSTGRESQL:
                $this->dbResource = new Postgresql();
                break;
            default:
                $this->dbResource = null;
                break;
        }
        return $this;
    }

    public function query()
    {
        if($this->dbResource == null)
        {
            throw new \Exception('No connection to database');
        }
        else
        {
            $queryResult = $this->dbResource->query();
            $this->lastQueryResult = $queryResult;
            return $queryResult;
        }
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
        return $this->dbResource->fetchArray($queryResult);
    }

    /**
     * @return string
     */
    public function getQueryStr(): string
    {
        return $this->dbResource->getQueryStr();
    }

    /**
     * @param array $fields
     * @param string $table
     * @return AbstractDatabase
     */
    public function select(array $fields, string $table): AbstractDatabase
    {
        return $this->dbResource->select($fields, $table);
    }

    /**
     * @param string $where
     * @return AbstractDatabase
     */
    public function where(string $where): AbstractDatabase
    {
        return $this->dbResource->where($where);
    }

    /**
     * @param string $limit
     * @return AbstractDatabase
     */
    public function limit(string $limit): AbstractDatabase
    {
        return $this->dbResource->limit($limit);
    }

    /**
     * @param string $expression
     * @return AbstractDatabase
     */
    public function and(string $expression): AbstractDatabase
    {
        return $this->dbResource->and($expression);
    }

    /**
     * @param string $expression
     * @return AbstractDatabase
     */
    public function or(string $expression): AbstractDatabase
    {
        return $this->or($expression);
    }
}