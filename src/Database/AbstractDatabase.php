<?php

namespace DBS2\Database;

require_once(__DIR__ . '/../../configuration.php');

abstract class AbstractDatabase
{
    public const FETCH_ASSOC = true;

    /** Connect to database */
    abstract public function connect();
    /** execute a query */
    abstract public function query();
    abstract public function fetchArray($queryResult = null);

    abstract public function getQueryStr(): string;
    abstract public function select(array $fields, string $table): self;
    abstract public function where(string $where): self;
    abstract public function limit(string $limit): self;
    abstract public function and(string $expression): self;
    abstract public function or(string $expression): self;
}