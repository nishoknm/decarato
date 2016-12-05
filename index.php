<?php
session_start();
$signin="Sign-up";
if(!empty($_SESSION["id"])){
    $signin="My Profile";
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="default.css">
    </head>

    <body>
        <div id="container">
            <div id="header">
                <div>
                    <div style="float:right;height:70px">
                        <ul id="sublist">
                            <li><a href="./ownerlogin">Product Owner Login</a> | </li>
                            <li><a href="./signup"><?php echo $signin ?></a> | </li>
                            <li><a href="./contactus">Contact us</a></li>
                        </ul>
                        <div id="login">
                            <?php if(!empty($_SESSION["id"])) : ?>
                                Logged in as :
                                <?php echo $_SESSION["id"] ?>
                                    <form action="model.php" method="post" id="logout" name="logout" class="formlogout">
                                        <button type="submit" class="loginoutbutton" name="websubmit" value="logout" id="u_0_11">Logout</button>
                                    </form>
                                <?php else : ?>
                                        <div class="login">
                                            <form action="model.php" method="post" id="loginout" name="login">
                                                <input type="text" name="email" placeholder=" E-mail" class="logininput">
                                                <input type="password" name="password" placeholder=" Password" class="logininput">
                                                <button type="submit" class="loginoutbutton" name="websubmit" value="login" id="u_0_10">Login</button>
                                            </form>
                                        </div>
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
                    <li><a href="./">Home</a> | </li>
                    <li><a href="./catalog">Product Catalog</a> | </li>
                    <li><a href="./checkout">Checkout</a> | </li>
                    <li><a href="./cart">Cart</a></li>
                </ul>
            </div>
            <div id="entrycontent">
                <div class="slider" id="slider"></div>
                <h1 class="_52lc">Decarator Interior Crafts - Better comfort </h1>
            </div>
            <div id="footer">
                <div id="footertop">
                    <p><strong>Decarato Interior Crafts</strong>
                        <br>Montclair, NJ, USA
                        <br>Phone: 111.111.1111 | Fax: 111.111.2222</p>
                </div>
                <div id="footerbottom">
                    <ul id="footerlist">
                        <li>
                            <a href="new.html" title="AccessKey: b" accesskey="b"><img src="images/facebook.png" alt="Facebook" /></a>
                        </li>
                        <li>
                            <a href="new.html" title="AccessKey: d" accesskey="d"><img src="images/linkedin.png" alt="LinkedIn" /></a>
                        </li>
                        <li>
                            <a href="new.html" title="AccessKey: g" accesskey="g"><img src="images/twitter.png" alt="Twitter" /></a>
                        </li>
                        <li>
                            <a href="new.html" title="AccessKey: h" accesskey="h"><img src="images/google.png" alt="Google" /></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>

    </html>
