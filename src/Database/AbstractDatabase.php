<?php

namespace DBS2\Database;

require_once(__DIR__ . '/../../configuration.php');

abstract class AbstractDatabase
{
    public const FETCH_ASSOC = true;

    /** Connect to database */
    abstract public function connect();
    /** execute a query */
    abstract public function query(string $queryStr);
    abstract public function fetchArray($queryResult = null);
}