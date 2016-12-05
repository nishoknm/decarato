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
                    if(cell != element && !cell.getAttribute("alwaysdisable")){
                        cell.removeAttribute("disabled");
                    }
                }
                diableEnableCheck(element, true);
                enableDisableUpdateDelete(true);
            } else {
                for (var i = 0; i < children.length; i++) {
                    var cell = children[i].children[0];
                    cell.removeAttribute("name");
                    if (cell != element && !cell.getAttribute("alwaysdisable")) {
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
        <?php include('../headerview.php') ?>
        <div id="entrycontent">
            <div class="pvl toolbar">
                <div class="_52lq">Edit Cart</div>
            </div>
            <div>
                <form action="../model.php" method="post" id="cartform" name="cartform">
                    <div class="toolbar">
                        <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_cart">Delete</button>
                        <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_cart">Update</button>
                    </div>
                    <table class="admint">
                        <thead>
                            <tr>
                                <th class="checkcell"></th>
                                <th><input class="ainputtext" readonly value="Product"></th>
                                <th><input class="ainputtext" readonly value="Product Name"></th>
                                <th><input class="ainputtext" readonly value="Quantity"></th>
                                <th><input class="ainputtext" readonly value="Price"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ( $cart as $ct ) : ?>
                            <tr>
                                <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                <td>
                                    <input xname="prodid" value='<?php echo $ct['productid']; ?>' style="display:none">
                                    <input disabled readonly class="ainputtext" alwaysdisable=true xname="prodid" value='<?php echo $ct['productid']; ?>' >
                                </td>
                                <td><input disabled class="ainputtext" alwaysdisable=true xname="title" value='<?php echo $ct['title']; ?>' ></td>
                                <td><input disabled class="ainputtext" xname="quantity" value='<?php echo $ct['quantity']; ?>' ></td>
                                <td><input disabled class="ainputtext" alwaysdisable=true xname="price" value='<?php echo $ct['price']; ?>' ></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input name="email" value='<?php echo $user['email']; ?>' style="display:none">
                </form>
            </div>
            <div class="footerbtns">
                <div class="toolbar">
                    <button id="continue" class="u_admin_toolbar" onclick="document.location.href='../catalog';">Continue Shopping</button>
                    <button id="checkout" class="u_admin_toolbar" onclick="document.location.href='../checkout';">Checkout</button>
                </div>
            </div>
        <?php include('../footerview.php') ?>
    </div>
</body>

</html>
