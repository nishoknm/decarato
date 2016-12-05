<?php
session_start();
if(!empty($_SESSION["id"]))
{
    require_once('../database.php');
    $user = get_user($_SESSION["id"]);
    $cart = get_cart_details($user["email"]);
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
            <div class="pvl toolbar">
                <div class="_52lq">Summary</div>
            </div>
            <div>
                <table class="admint">
                    <thead>
                        <tr>
                            <th><input class="ainputtext" readonly value="Product"></th>
                            <th><input class="ainputtext" readonly value="Product Name"></th>
                            <th><input class="ainputtext" readonly value="Quantity"></th>
                            <th><input class="ainputtext" readonly value="Price"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ( $cart as $ct ) : ?>
                        <tr>
                            <td><input disabled readonly class="ainputtext" alwaysdisable=true xname="prodid" value='<?php echo $ct['productid']; ?>' ></td>
                            <td><input disabled class="ainputtext" alwaysdisable=true xname="title" value='<?php echo $ct['title']; ?>' ></td>
                            <td><input disabled class="ainputtext" xname="quantity" value='<?php echo $ct['quantity']; ?>' ></td>
                            <td><input disabled class="ainputtext" alwaysdisable=true xname="price" value='<?php echo $ct['price']; ?>' ></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="footerbtns">
                <form action="../model.php" method="post" id="checkoutform" name="checkoutform">
                    <div class="toolbar">
                        <button id="continue" class="u_admin_toolbar" onclick="document.location.href='../catalog';">Select Payment</button>
                        <button id="checkout" class="u_admin_toolbar" onclick="document.location.href='../checkout';">Pay</button>
                    </div>
                    <input name="email" value='<?php echo $user['email']; ?>' style="display:none">
                </form>
            </div>
        </div>
        <?php include('../footerview.php') ?>
    </div>

</body>

</html>
