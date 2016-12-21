<?php
session_start();
if(!empty($_SESSION["id"]))
{
    require_once('../database.php');
    $user = get_user($_SESSION["id"]);
    $cart = get_cart_details($user["email"]);
    $carddetails = get_user_cards($user["email"]);
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
            <?php if(!empty($_SESSION["id"])) : ?>
                <?php if(!empty($_SESSION["owner"])) : ?>
                    <div id="signup">
                        <div class="pvl">
                            <div class="_52lt">Owner</div>
                        </div>
                        <div id="reg_form_box" class="large_form">
                            <div class="pvl">
                                <div class="_52lt">Not Available for Owner</div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
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
                                <select class="u_admin_toolbar" name="paymentcard">
                                    <?php foreach ( $carddetails as $cd ) : ?>
                                        <option value='<?php echo $cd['cardnumber']; ?>' title='<?php echo $cd['cardnumber']; ?>'><?php echo $cd['cardnumber']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button id="checkout" type="submit" class="u_admin_toolbar" name="websubmit" value="pay_transaction">Pay</button>
                            </div>
                            <input name="email" value='<?php echo $user['email']; ?>' style="display:none">
                        </form>
                    </div>
                <?php endif; ?>
            <?php else : ?>
            <div id="signup">
                <div class="pvl">
                    <div class="_52lt">Summary</div>
                </div>
                <div id="reg_form_box" class="large_form">
                    <div class="pvl">
                        <div class="_52lt">Please <a style="text-decoration:none" href="../signup">Sign-up</a> or Sign-in on header to checkout.</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php include('../footerview.php') ?>
    </div>

</body>

</html>
