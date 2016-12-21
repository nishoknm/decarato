<?php
session_start();
if(!empty($_SESSION["id"]))
{
    require_once('../database.php');
    $user = get_user($_SESSION["id"]);
    $user_transactions = get_user_transaction($user['email']);
    $user_pays = get_user_pay($user['email']);
    $newemail = $user['email'];
    $fName = $user['fname'];
    $lName = $user['lname'];
    $number = $user['number'];
    $address = $user['address'];
    $comOrg = $user['company'];
    $pass = $user['password'];
    $sex = $user['sex'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../default.css">
        <script>
        var selectedItem;
        var selectedLi;

        function loaded(eve) {
            var list = document.getElementById("speakerlist");
            selectedLi = list.children[0];
            selectedLi.className = " listactive";
            selectedItem = "profile";
        }

        function selectList(eve) {

            selectedLi.className = ""
            document.getElementById(selectedItem).className = "speaker";

            var ele = eve.target;
            selectedLi = ele;
            selectedLi.className = " listactive";

            selectedItem = selectedLi.getAttribute("value");
            document.getElementById(selectedItem).className += " active";
        }

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
            var deletebtn = currentForm.querySelector("#delete")
            if (enable) {
                deletebtn.removeAttribute("disabled");
            } else {
                deletebtn.setAttribute("disabled", true);
            }
        }

        function changeborder(cell, selected) {
            if (selected) cell.className += " border";
            else cell.className = cell.className.replace(' border', '');
        }
        </script>
    </head>
    <body onload="loaded(event)">
        <div id="container">
            <?php include('../headerview.php') ?>
            <div id="entrycontent">
                <?php if(empty($_SESSION["id"])) : ?>
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
                    <div id="signup">
                        <div class="pvl">
                            <div class="_52lq">Sign Up</div>
                        </div>
                        <form action="../model.php" method="post" id="reg" name="reg">
                            <div id="reg_form_box" class="large_form">
                                <div class="clearfix _58mh">
                                    <div class="mbm _3-90 lfloat _ohe">
                                        <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                            <input name="fName" type="text" class="inputtext transparent" placeholder="First name">
                                        </div>
                                    </div>
                                    <div class="mbm rfloat _ohf">
                                        <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                            <input name="lName" type="text" class="inputtext transparent" placeholder="Last name">
                                        </div>
                                    </div>
                                </div>
                                <div class="mbm">
                                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                        <input name="email" type="text" class="inputtext transparent _58mg" placeholder="Email">
                                    </div>
                                </div>
                                <div class="mbm" id="u_0_3">
                                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                        <input name="number" type="text" class="inputtext transparent _58mg" placeholder="Mobile number">
                                    </div>
                                </div>
                                <div class="mbm" id="u_0_5">
                                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                        <input name="address" type="text" class="inputtext transparent _58mg" placeholder="Address">
                                    </div>
                                </div>
                                <div class="mbm" id="u_0_7">
                                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                        <input name="comOrg" type="text" class="inputtext transparent _58mg" placeholder="Company or Organization">
                                    </div>
                                </div>
                                <div class="mbm">
                                    <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                        <input name="password" type="password" class="inputtext transparent _58mg" placeholder="New password">
                                    </div>
                                </div>
                                <div class="mtm _5wa2 _5dbb"><span class="_5k_3"><span class="_5k_2 _5dba"><input type="radio" name="sex" value="Female" id="u_0_6"><label class="_52lr">Female</label></span><span class="_5k_2 _5dba"><input type="radio" name="sex" value="Male" id="u_0_7"><label class="_52lr">Male</label></span></span><i class="_5dbc _5k_6 img sp_LGqQTdUydKB sx_a32b95"></i><i class="_5dbd _5k_7 img sp_LGqQTdUydKB sx_b4917b"></i></div>
                                <div class="_52lr" id="u_0_8">
                                    <p class="_52lr">By clicking Sign Up, you agree to our Terms and that you have read our Data Policy, including our Cookie Use.</p>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="_52lq" name="websubmit" value="signup" id="u_0_9">Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                <?php else : ?>
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
                    <div id="speakermenu">
                        <ul id="speakerlist">
                            <li name="speakers" onclick="selectList(event)" value="profile">My Profile</li>
                            <li name="speakers" onclick="selectList(event)" value="history">Transaction History</li>
                            <li name="speakers" onclick="selectList(event)" value="payment">Payment</li>
                        </ul>
                    </div>
                    <div id="speakercontainer">
                        <div id="profile" class="speaker active">
                            <div style="float: left;">
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
                                    <div class="mbm">
                                        <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                            <div class="placeholder"><b>Company : </b>
                                                <?php echo $comOrg ?>
                                            </div>
                                            <input disabled name="company" type="text" class="inputtext transparent _58mg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="history" class="speaker">
                            <div style="float: left;">
                                <table class="admint">
                                    <thead>
                                        <tr>
                                            <th><input class="ainputtext" readonly value="Transaction"></th>
                                            <th><input class="ainputtext" readonly value="Product"></th>
                                            <th><input class="ainputtext" readonly value="Name"></th>
                                            <th><input class="ainputtext" readonly value="Quantity"></th>
                                            <th><input class="ainputtext" readonly value="Price"></th>
                                            <th><input class="ainputtext" readonly value="Total"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $user_transactions as $ut ) : ?>
                                        <tr>
                                            <td><input disabled readonly class="ainputtext" xname="eemail" value='<?php echo $ut['transactionid']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="efName" value='<?php echo $ut['productid']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="elName" value='<?php echo $ut['title']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="enumber" value='<?php echo $ut['quantity']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="epassword" value='<?php echo $ut['price']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="eaddress" value='<?php echo $ut['totalprice']; ?>' ></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="payment" class="speaker">
                            <div style="float: left;">
                                <div class="pvl">
                                    <div class="_52lq">Payment Info</div>
                                </div>
                                <form action="../model.php" method="post" id="payform" name="payform">
                                    <div class="toolbar">
                                        <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_pay">Delete</button>
                                        <button type="submit" class="u_admin_toolbar" name="websubmit" value="add_card" id="add">Add</button>
                                    </div>
                                    <table class="admint">
                                        <thead>
                                            <tr>
                                                <th class="checkcell"></th>
                                                <th><input class="ainputtext" readonly value="Card Number"></th>
                                                <th><input class="ainputtext" readonly value="Card Type"></th>
                                                <th><input class="ainputtext" readonly value="CVV"></th>
                                                <th><input class="ainputtext" readonly value="Expiry Date"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ( $user_pays as $upay ) : ?>
                                            <tr>
                                                <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                                <td><input readonly disabled class="ainputtext" xname="ucno" value='<?php echo $upay['cardnumber']; ?>' ></td>
                                                <td><input readonly disabled class="ainputtext" xname="uctype" value='<?php echo $upay['cardtype']; ?>' ></td>
                                                <td><input readonly disabled class="ainputtext" xname="ucvv" value='<?php echo $upay['cvv']; ?>' ></td>
                                                <td><input readonly disabled class="ainputtext" xname="uexpiry" value='<?php echo $upay['expiry']; ?>' ></td>
                                            </tr>
                                        <?php endforeach; ?>
                                            <tr>
                                                <td></td>
                                                <td><input name="cno" placeholder="Card Number" type="text" class="ainputtext"></td>
                                                <td><input name="ctype" placeholder="Card Type" type="text" class="ainputtext"></td>
                                                <td><input name="cvv" placeholder="CVV" type="text" class="ainputtext"></td>
                                                <td><input name="expiry" placeholder="Expiry Date" type="date" class="ainputtext"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input name="email" value='<?php echo $user['email']; ?>' style="display:none">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php include('../footerview.php') ?>
        </div>
    </body>
</html>