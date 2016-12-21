<?php
session_start();
if(!empty($_SESSION["owner"]))
{
    require_once('../database.php');
    $owner = $_SESSION["owner"];
    $products = get_products_owner($owner);
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

        function oncheck(event , storeOld) {
            var element = event.target;
            currentForm = element.form;
            var row = element.parentNode.parentNode;
            var children = row.children;
            if (element.checked) {
                for (var i = 0; i < children.length; i++) {
                    var cell = children[i].children[0];
                    cell.setAttribute("name", cell.getAttribute("xname"));
                    if(cell != element){
                        cell.removeAttribute("disabled");
                    }
                }
                diableEnableCheck(element, true);
                enableDisableUpdateDelete(true);
            } else {
                for (var i = 0; i < children.length; i++) {
                    var cell = children[i].children[0];
                    cell.removeAttribute("name");
                    if (cell != element) {
                        cell.setAttribute("disabled", true);
                    }
                }
                diableEnableCheck(element, false);
                enableDisableUpdateDelete(false);
            }
            storeOldValues(currentForm, storeOld);
        }

        function storeOldValues(form, store) {
            if(store) {
                var attrval;
                var old;
                var olds = currentForm.querySelectorAll("#old");
                for (var i = 0; i < olds.length; i++) {
                    old = olds[i];
                    attrval = old.getAttribute("oldname");
                    old.setAttribute("value",currentForm.querySelector("[name='"+attrval+"']").value);
                }
            }
        }

        function setFile(event) {
            var element = event.target;
            var row = element.parentNode.parentNode;
            row.querySelector("#file").value = element.selectedOptions[0].getAttribute("filename");
        }

        function diableEnableCheck(element, disable) {
            var checks = currentForm.querySelectorAll(".check");
            var check;
            for (var i = 0; i < checks.length; i++) {
                check = checks[i];
                if (check != element) {
                    if (disable) check.disabled = true;
                    else check.disabled = false;
                }
            }
        }

        function enableDisableUpdateDelete(enable) {
            var update = currentForm.querySelector("#update");
            var deletebtn = currentForm.querySelector("#delete")
            if (enable) {
                update.removeAttribute("disabled");
                deletebtn.removeAttribute("disabled");
            } else {
                update.setAttribute("disabled", true);
                deletebtn.setAttribute("disabled", true);
            }
        }

        function changeborder(cell, selected) {
            if (selected) cell.className += " border";
            else cell.className = cell.className.replace(' border', '');
        }
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
            <?php if(!empty($_SESSION["owner"])) : ?>
                <div id="product">
                    <div class="pvl toolbar">
                        <div class="_52lq">Add Product</div>
                    </div>
                    <div>
                        <form action="../model.php" method="post" id="reviewerform" name="reviewerform">
                            <div class="toolbar">
                                <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_product">Delete</button>
                                <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_product">Update</button>
                            </div>
                            <table class="admint">
                                <thead>
                                    <tr>
                                        <th class="checkcell"></th>
                                        <th><input class="ainputtext" readonly value="Title"></th>
                                        <th><input class="ainputtext" readonly value="Image file"></th>
                                        <th><input class="ainputtext" readonly value="Category"></th>
                                        <th><input class="ainputtext" readonly value="price"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ( $products as $product ) : ?>
                                    <tr>
                                        <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                        <td><input disabled class="ainputtext" xname="utitle" value='<?php echo $product['title']; ?>' ></td>
                                        <td><input disabled class="ainputtext" xname="uimagefile" value='<?php echo $product['imagefile']; ?>' ></td>
                                        <td><input disabled class="ainputtext" xname="utype" value='<?php echo $product['type']; ?>' ></td>
                                        <td><input disabled class="ainputtext" xname="uprice" value='<?php echo $product['price']; ?>' ></td>
                                        <td style="display:none"><input xname="pid" value='<?php echo $product['productid']; ?>' style="display:none"></td>
                                    </tr>
                                <?php endforeach; ?>
                                    <tr>
                                        <td></td>
                                        <td><input name="title" placeholder="Title" type="text" class="ainputtext"></td>
                                        <td><input name="imagefile" placeholder="Image File" type="text" class="ainputtext"></td>
                                        <td><input name="type" placeholder="Type" type="text" class="ainputtext"></td>
                                        <td><input name="price" placeholder="Price" type="text" class="ainputtext"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="adminc">
                                <div class="clearfix">
                                    <button type="submit" class="_52lq" name="websubmit" value="add_product" id="u_admin_review">Add Product</button>
                                </div>
                            </div>
                            <input name="email" value='<?php echo $owner; ?>' style="display:none">
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <div id="signup">
                    <div class="pvl">
                        <div class="_52lt">Owner</div>
                    </div>
                    <div id="reg_form_box" class="large_form">
                        <div class="pvl">
                            <div class="_52lt">Please <a style="text-decoration:none" href="../signup">Sign-up</a> or Sign-in on header.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php include('../footerview.php') ?>
    </div>
</body>

</html>
