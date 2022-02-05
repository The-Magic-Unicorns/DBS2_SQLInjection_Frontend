<?php

require_once(__DIR__ . '/configuration.php');
require_once(__DIR__ . '/php_include/Database.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SQL Injection</title>
    <link rel="stylesheet" href="css/bootstrap-4.0.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
    <header class="jumbotron">
        <h1>Learning SQL Injection</h1>
    </header>
    <div class="wrapper">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="dbtype">Chose a database type:</label>
                <select name="dbtype" class="form-control">
                    <option value="0">--Please select a datase--</option>
                    <option value="<?php Database::$MARIADB ?>">MariaDB</option>
                    <option value="<?php Database::$POSTGRESQL ?>">Postgresql</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search">Search</label>
                <input name="search" class="form-control" />
            </div>
            <div class="form-group">
                <label for="limit_result">Limit result</label>
                <input type="number" name="limit_result" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" />
                <input type="reset" class="btn btn-danger" />
            </div>
        </form>
    </div>

    <div class="result">
        <?php
            // check if form was submitted
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $dbtype = intval($_POST['dbtype']);
                $search = $_POST['search'];
                $limit_result = $_POST['limit_result'];

                $dbcon = new Database;
                $dbcon->connect($dbtype);

            }
        ?>
    </div>

</body>
</html>