<?php

require_once(__DIR__ . '/configuration.php');

use DBS2\Database\Database;
use DBS2\Debug\Logger;

session_start();

if(!isset($_SESSION['dbType']))
{
    header('Location: /frontend_php/settings.php');
}

?>

<?php require_once(__DIR__ . '/frontend_php/header.inc.php'); ?>
<div class="wrapper">
    <div class="description">
        <p>This is a little search engine for the MITRE ATT&CK database (https://attack.mitre.org)</p>
        <p>Use sql like syntax for your search (*, %, AND, OR, ...)</p>
    </div>
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
            $dbCon->select(array('*'), 'targets_industrytype')
                ->where('industrytype LIKE \'' . $search . '\'');
            if(intval($limitResult) > 0)
            {
                $dbCon->limit($limitResult);
            }

            $logger = new Logger();
            $logger->log('New search: "' . $dbCon->getQueryStr() . '" from client ip ' . $_SERVER['REMOTE_ADDR'] . "\n");
            $dbCon->query();
            $resultArray = $dbCon->fetchArray();

            echo('<table class="table table-striped">'
                . '<tr>'
                    . '<th></th>'
                    . '<th>Industrytype</th>'
                    . '<th>Description</th>'
                . '</tr>');
            $i = 1;
            foreach($resultArray as $resultRow)
            {
                echo("<br />");
                echo('<tr>'
                        . '<td>' . $i . '</td>'
                        . '<td>' . $resultRow['industrytype'] . '</td>'
                        . '<td>' . $resultRow['description'] .'</td>'
                    . '</tr>');
                $i += 1;
            }
            echo('</table>');
        }
    ?>
</div>
<?php require_once(__DIR__ . '/frontend_php/footer.inc.php'); ?>