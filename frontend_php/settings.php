<?php

require_once(__DIR__ . '/../configuration.php');

session_start();

// check if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $_SESSION['dbType'] = $_POST['dbType'];
    header('Location: /');
}

?>

<?php require_once(__DIR__ . '/header.inc.php'); ?>
    <div class="wrapper">
        <div class="select-database-form">
            <form action="settings.php" method="post">
                <div class="form-group">
                    <label for="dbType">Database Type</label>
                    <select name="dbType" class="form-control">
                        <?php
                        foreach($CONFIG['db'] as $index => $db)
                        {
                            echo('<p>' . $_SESSION['dbType'] . ' -- ' . $index . '</p>');
                            if($index == $_SESSION['dbType'])
                            {
                                echo('<option value="' . $index . '" selected="selected">' . $db['name'] . '</option>');
                            }
                            else
                            {
                                echo('<option value="' . $index . '">' . $db['name'] . '</option>');
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
            <?php  ?>
        </div>
    </div>
<?php require_once(__DIR__ . '/footer.inc.php'); ?>