<?php

require_once(__DIR__ . '/configuration.php');
require_once(__DIR__ . '/vendor/autoload.php');

use DBS2\Database\Database;

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
                <label for="dbType">Chose a database type:</label>
                <select name="dbType" class="form-control">
                    <option value="0">--Please select a datase--</option>
                    <option value="<?php Database::MARIADB ?>">MariaDB</option>
                    <option value="<?php Database::POSTGRESQL ?>">Postgresql</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search">Search</label>
                <input name="search" class="form-control" />
            </div>
            <div class="form-group">
                <label for="limitResult">Limit result</label>
                <input type="number" name="limitResult" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>

    <div class="result">
        <?php
            // check if form was submitted
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $dbType = intval($_POST['dbType']);
                $search = $_POST['search'];
                $limitResult = $_POST['limitResult'];

                $dbcon = new Database($dbType);
            }
        ?>
    </div>

</body>
</html>