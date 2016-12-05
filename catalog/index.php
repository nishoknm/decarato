<?php
session_start();
if(!empty($_SESSION["id"]))
{
    require_once('../database.php');
    $user = get_user($_SESSION["id"]);
    $products = get_products();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../default.css">
    <style>
    #entrycontent {
        padding-left: 10%;
    }
    </style>
    <script>
        var currentForm;

        function clickCart(event) {
            var element = event.target;
            var proEle = element.nextElementSibling;
            var webSubEle = proEle.nextElementSibling;
            proEle.setAttribute("name", proEle.getAttribute("xname"));
            webSubEle.setAttribute("name", webSubEle.getAttribute("xname"));
            var currentForm = proEle.form;
            currentForm.submit();
        }
        </script>
</head>

<body>
    <div id="container">
        <?php include('../headerview.php') ?>
        <div id="entrycontent">
            <form action="../model.php" method="post" name="catalogform">
                <ul class="products">
                <?php foreach ( $products as $product ) : ?>
                    <li>
                        <img src='<?php echo $product['imagefile']; ?>' />
                        <div class="info">
                            <h3><?php echo $product['title']; ?></h3>
                            <span>$<?php echo $product['price']; ?></span>
                        </div>
                        <div class="desc">
                            <a class="buy" href="javascript:void(0)" onclick="clickCart(event);">Add To Cart </a>
                            <input xname="proid" value='<?php echo $product['productid']; ?>' style="display:none">
                            <input xname="websubmit" value="addcart" style="display:none">
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
                <input name="email" value='<?php echo $user['email']; ?>' style="display:none">
            </form>
        </div>
        <?php include('../footerview.php') ?>
    </div>
</body>

</html>
