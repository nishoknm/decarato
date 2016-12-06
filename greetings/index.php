<?php
session_start();
if(!empty($_SESSION["id"]))
{
    require_once('../database.php');
    $user = get_user($_SESSION["id"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../default.css">
    <script>
    </script>
</head>

<body>
    <div id="container">
        <?php include('../headerview.php') ?>
        <div id="entrycontent">
            <div class="pvl toolbar centervertical">
                <div class="_52lq">Thank you for Shopping ..! </div>
            </div>
        </div>
        <?php include('../footerview.php') ?>
    </div>

</body>

</html>
