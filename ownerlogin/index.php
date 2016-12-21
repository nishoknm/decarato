<?php
session_start();
if(!empty($_SESSION["owner"]))
{
    require_once('../database.php');
    $owner = get_owner($_SESSION["owner"]);
    $newemail = $owner['email'];
    $fName = $owner['fname'];
    $lName = $owner['lname'];
    $number = $owner['number'];
    $address = $owner['address'];
    $pass = $owner['password'];
    $sex = $owner['sex'];
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
        <div id="header">
            <div>
                <div style="float:right;height:70px">
                    <ul id="sublist">
                    <?php if(empty($_SESSION["owner"])) : ?>
                        <li><a href="../ownerlogin">Product Owner Login</a></li>
                    <?php endif; ?>
                    </ul>
                    <div id="login">
                        <?php if(!empty($_SESSION["owner"])) : ?>
                            Logged in as :
                            <?php echo $_SESSION["owner"] ?>
                                <form action="../model.php" method="post" id="logout" name="logout" class="formlogout">
                                    <button type="submit" class="loginoutbutton" name="websubmit" value="logout" id="u_0_11">Logout</button>
                                </form>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="multicolor-bar">
                <div class="col-xs-2 colorblock-1"></div>
                <div class="col-xs-2 colorblock-2"></div>
                <div class="col-xs-2 colorblock-3"></div>
                <div class="col-xs-2 colorblock-4"></div>
                <div class="col-xs-2 colorblock-5"></div>
                <div class="col-xs-2 colorblock-6"></div>
            </div>
            <ul id="mainlist">
                <li><a href="../product">Products</a></li>
            </ul>
        </div>
        <div id="entrycontent">
            <?php if(empty($_SESSION["owner"])) : ?>
            <div id="signup">
                <div class="pvl">
                    <div class="_52lq">Owner Login</div>
                </div>
                <form action="../model.php" method="post" id="reg" name="reg">
                    <div id="reg_form_box" class="large_form">
                        <div class="clearfix _58mh">
                            <div class="mbm _3-90 lfloat _ohe">
                                <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                    <input name="uname" type="text" placeholder="User Name" class="inputtext transparent">
                                </div>
                            </div>
                            <div class="mbm rfloat _ohf">
                                <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                    <input name="pass" type="password" placeholder="Password" class="inputtext transparent">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button type="submit" class="_52lq" name="websubmit" value="owner_login" id="u_0_9">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php else : ?>
            <div class="pvl">
                <div class="_52lq">User Information</div>
            </div>
            <div id="reg_form_box" class="large_form">
                <div class="mbm">
                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                        <div class="placeholder"><b>Full Name : </b>
                            <?php echo $lName.", ".$fName ?>
                        </div>
                        <input disabled name="name" type="text" class="inputtext transparent _58mg">
                    </div>
                </div>
                <div class="mbm">
                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                        <div class="placeholder"><b>E-mail : </b>
                            <?php echo $newemail ?>
                        </div>
                        <input disabled name="email" type="text" class="inputtext transparent _58mg">
                    </div>
                </div>
                <div class="mbm">
                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                        <div class="placeholder"><b>Number : </b>
                            <?php echo $number ?>
                        </div>
                        <input disabled name="number" type="text" class="inputtext transparent _58mg">
                    </div>
                </div>
                <div class="mbm">
                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                        <div class="placeholder"><b>Address : </b>
                            <?php echo $address ?>
                        </div>
                        <input disabled name="address" type="text" class="inputtext transparent _58mg">
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php include('../footerview.php') ?>
    </div>
</body>

</html>
