<?php
session_start();
if(!empty($_SESSION["id"]))
    {
    require_once('../database.php');
    if(!empty($_SESSION["catid"]))
    {
        $cat = $_SESSION["catid"];
        if($cat != "all")
        {
            $products = get_products_cat($cat);
        }
        else
        {
            $products = get_products();
        }
    }
    elseif(!empty($_SESSION["qid"])){
        $cat = $_SESSION["qid"];
        $products = get_products_query($cat);
    }
    else
    {
        $products = get_products();
    }
    $categories = get_categories();
    if(!empty($_SESSION["id"]))
    {
        $user = get_user($_SESSION["id"]);
    }
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

        function selectCategory(event){
            var element = event.target;
            element.setAttribute("name", element.getAttribute("xname"));
            var catid = element.previousElementSibling;
            catid.setAttribute("name", catid.getAttribute("xname"));
            var currentForm = element.form;
            currentForm.submit();
        }
        </script>
</head>

<body>
    <div id="container">
        <?php include('../headerview.php') ?>
        <div id="entrycontent">
            <?php if(!empty($_SESSION["id"])) : ?>
                <form action="../model.php" method="post" name="catalogform">
                    <ul class="categories">
                        <li>
                            <input xname="catid" value='all' style="display:none">
                            <button xname="websubmit" value="selectcategory" onclick="selectCategory(event);">ALL</button>
                        </li>
                        <?php foreach ( $categories as $category ) : ?>
                        <li>
                            <input xname="catid" value='<?php echo $category['id']; ?>' style="display:none">
                            <button xname="websubmit" value="selectcategory" onclick="selectCategory(event);"><?php echo $category['title']; ?></button>
                        </li>
                        <?php endforeach; ?> 
                        <li>
                            <input xname="qid">
                            <button xname="websubmit" value="querycategory" onclick="selectCategory(event);">GO</button>
                        </li>
                    </ul>
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
            <?php else : ?>
                <div id="signup">
                    <div class="pvl">
                        <div class="_52lt">Catalog</div>
                    </div>
                    <div id="reg_form_box" class="large_form">
                        <div class="pvl">
                            <div class="_52lt">Please <a style="text-decoration:none" href="../signup">Sign-up</a> or Sign-in on header to View Catalog.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php include('../footerview.php') ?>
    </div>
</body>

</html>
