<?php

require_once(__DIR__ . '/vendor/autoload.php');

$CONFIG = array(
    'db' => array(
        'psql' => array(
            'name' => 'PostgreSQL',
            'type' => DBS2\Database\Database::POSTGRESQL,
            'host' => '127.0.0.1',
            'dbname' => 'postgres',
            'user' => 'postgres',
            'password' => 'mysecretpassword',
            'schema' => 'apl'
        ),
        'mariadb' => array(
            'name' => 'MariaDB',
            'type' => DBS2\Database\Database::MARIADB,
            'host' => '127.0.0.1',
            'dbname' => 'datenbanken01',
            'user' => 'root',
            'password' => 'mysecretpassword',
        ),
        'mariadb_azure' => array(
            'name' => 'MariaDB Azure Cloud',
            'type' => DBS2\Database\Database::MARIADB,
            'host' => 'wings-mariadb-forensic.mariadb.database.azure.com',
            'dbname' => 'datenbanken01',
            'user' => 'azureuser@wings-mariadb-forensic',
            'password' => 'mysecretpassword',
        )
    )
);