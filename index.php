<?php

require_once(__DIR__ . '/configuration.php');

use DBS2\Database\Database;

session_start();

?>

<?php require_once(__DIR__ . '/frontend_php/header.inc.php'); ?>
<div class="wrapper">

    <div class="search-form">
        <form action="index.php" method="post">
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
</div>

<div class="result">
    <?php
        // check if form was submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $search = $_POST['search'];
            $limitResult = $_POST['limitResult'];

            $dbCon = new Database($CONFIG['db'][$_SESSION['dbType']]['type']);
            $dbCon->select(array('*'), 'mitigates');

            $dbCon->query();
            $resultArray = $dbCon->fetchArray();
            print_r($resultArray);
        }
    ?>
</div>
<?php require_once(__DIR__ . '/frontend_php/footer.inc.php'); ?>