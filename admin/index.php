<?php
session_start();
if(!empty($_SESSION["admin"]))
{
    require_once('../database.php');
    $owners = get_owners();
    $users = get_users();
    $products = get_products();
    $catalogs = get_catalogs();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../default.css">
        <script>
        if (document.location.hash == "" || document.location.hash == "#")
            document.location.hash = "#owner";

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
        <?php if(empty($_SESSION["admin"])) : ?>
        <div id="dialogdiv">
            <div class="dialog">
                <form action="../model.php" method="post" id="reg" name="reg">
                    <div class="clearfix _58mh padtop">
                        <div class="mbm rfloat _ohf">
                            <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                <input name="uname" type="text" class="inputtext transparent" placeholder="User Name">
                            </div>
                        </div>
                        <div class="mbm rfloat _ohf">
                            <div class="uiStickyPlaceholderInput uiStickyPlaceholderEmptyInput">
                                <input name="pass" type="password" class="inputtext transparent" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="clearfixadmin">
                        <button type="submit" name="websubmit" id="u_admin" value="admin_login">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <?php else : ?>
        <div id="container">
            <div id="header">
                <div>
                    <div style="float:right;height:70px">
                        <div>Admin Login</div>
                        <div id="login">
                            Logged in as :
                            <?php echo $_SESSION["admin"] ?>
                            <form action="../model.php" method="post" id="logout" name="logout" class="formlogout">
                                <button type="submit" class="loginoutbutton" value="admin_logout" name="websubmit" id="u_0_11">Logout</button>
                            </form>
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
                    <li><a href="#owner">Owner</a> | </li>
                    <li><a href="#product">Product</a> | </li>
                    <li><a href="#user">User</a> | </li>
                    <li><a href="#catalog">Catalog</a></li>
                </ul>
            </div>
            <div id="entrycontent">
                <section>
                    <div class="admintable" id="owner">
                        <div class="pvl toolbar">
                            <div class="_52lq">Add owner</div>
                        </div>
                        <div>
                            <form action="../model.php" method="post" id="ownerform" name="ownerform">
                                <div class="toolbar">
                                    <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_owner">Delete</button>
                                    <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_owner">Update</button>
                                </div>
                                <table class="admint">
                                    <thead>
                                        <tr>
                                            <th class="checkcell"></th>
                                            <th><input class="ainputtext" readonly value="Email"></th>
                                            <th><input class="ainputtext" readonly value="First Name"></th>
                                            <th><input class="ainputtext" readonly value="Last Name"></th>
                                            <th><input class="ainputtext" readonly value="Number"></th>
                                            <th><input class="ainputtext" readonly value="Password"></th>
                                            <th><input class="ainputtext" readonly value="Address"></th>
                                            <th><input class="ainputtext" readonly value="Sex"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $owners as $owner ) : ?>
                                        <tr>
                                            <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                            <td><input disabled readonly class="ainputtext" xname="uemail" value='<?php echo $owner['email']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="ufName" value='<?php echo $owner['fname']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="ulName" value='<?php echo $owner['lname']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="unumber" value='<?php echo $owner['number']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="upassword" value='<?php echo $owner['password']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="uaddress" value='<?php echo $owner['address']; ?>' ></td>
                                            <td>
                                                <select disabled class="ainputtext" xname="usex" readonly>
                                                    <?php if ($owner['sex'] == 'Male'): ?>
                                                        <option value="Male" title="Male" selected>Male</option>
                                                        <option value="Female" title="Female">Female</option>
                                                    <?php else: ?>
                                                        <option value="Male" title="Male">Male</option>
                                                        <option value="Female" title="Female" selected>Female</option>
                                                    <?php endif ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td><input name="email" placeholder="Email" type="text" class="ainputtext"></td>
                                            <td><input name="fName" placeholder="First name" type="text" class="ainputtext"></td>
                                            <td><input name="lName" placeholder="Last name" type="text" class="ainputtext"></td>
                                            <td><input name="number" placeholder="Mobile number" type="text" class="ainputtext"></td>
                                            <td><input name="password" placeholder="New password" type="password" class="ainputtext"></td>
                                            <td><input name="address" placeholder="Address" type="text" class="ainputtext"></td>
                                            <td>
                                                <select name="sex" id="sex" class="ainputtext">
                                                    <option value="select">--Select--</option>
                                                    <option value="Male" title="Male">Male</option>
                                                    <option value="Female" title="Female">Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="adminc">
                                    <div class="clearfix">
                                        <button type="submit" class="_52lq" name="websubmit" value="add_owner" id="u_admin_review">Add owner</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="admintable" id="product">
                        <div class="pvl toolbar">
                            <div class="_52lq">Edit Product Information</div>
                        </div>
                        <div>
                            <form action="../model.php" method="post" id="adminproductform" name="adminproductform">
                                <div class="toolbar">
                                    <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_product_admin">Delete</button>
                                    <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_product_admin">Update</button>
                                </div>
                                <table class="admint">
                                <thead>
                                    <tr>
                                        <th class="checkcell"></th>
                                        <th><input class="ainputtext" readonly value="Title"></th>
                                        <th><input class="ainputtext" readonly value="Image file"></th>
                                        <th><input class="ainputtext" readonly value="Owner"></th>
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
                                        <td><input disabled class="ainputtext" xname="uowner" value='<?php echo $product['owneremail']; ?>' ></td>
                                        <td><input disabled class="ainputtext" xname="utype" value='<?php echo $product['type']; ?>' ></td>
                                        <td><input disabled class="ainputtext" xname="uprice" value='<?php echo $product['price']; ?>' ></td>
                                        <td style="display:none"><input xname="pid" value='<?php echo $product['productid']; ?>' style="display:none"></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="admintable" id="user">
                        <div class="pvl toolbar">
                            <div class="_52lq">Edit Users</div>
                        </div>
                        <div>
                            <form action="../model.php" method="post" id="userform" name="userform">
                                <div class="toolbar">
                                    <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_user_admin">Delete</button>
                                    <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_user_admin">Update</button>
                                </div>
                                <table class="admint">
                                    <thead>
                                        <tr>
                                            <th class="checkcell"></th>
                                            <th><input class="ainputtext" readonly value="Email"></th>
                                            <th><input class="ainputtext" readonly value="First Name"></th>
                                            <th><input class="ainputtext" readonly value="Last Name"></th>
                                            <th><input class="ainputtext" readonly value="Number"></th>
                                            <th><input class="ainputtext" readonly value="Password"></th>
                                            <th><input class="ainputtext" readonly value="Company"></th>
                                            <th><input class="ainputtext" readonly value="Address"></th>
                                            <th><input class="ainputtext" readonly value="Sex"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $users as $user ) : ?>
                                        <tr>
                                            <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                            <td><input disabled readonly class="ainputtext" xname="eemail" value='<?php echo $user['email']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="efName" value='<?php echo $user['fname']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="elName" value='<?php echo $user['lname']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="enumber" value='<?php echo $user['number']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="epassword" value='<?php echo $user['password']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="ecompany" value='<?php echo $user['company']; ?>' ></td>
                                            <td><input disabled class="ainputtext" xname="eaddress" value='<?php echo $user['address']; ?>' ></td>
                                            <td>
                                                <select disabled class="ainputtext" xname="esex" readonly>
                                                    <?php if ($user['sex'] == 'Male'): ?>
                                                        <option value="Male" title="Male" selected>Male</option>
                                                        <option value="Female" title="Female">Female</option>
                                                    <?php else: ?>
                                                        <option value="Male" title="Male">Male</option>
                                                        <option value="Female" title="Female" selected>Female</option>
                                                    <?php endif ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="admintable" id="catalog">
                        <div class="pvl toolbar">
                            <div class="_52lq">Catalog Information</div>
                        </div>
                        <div>
                            <form action="../model.php" method="post" id="catalogform" name="catalogform">
                                <div class="toolbar">
                                    <button id="delete" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="delete_catalog">Delete</button>
                                    <button id="update" disabled class="u_admin_toolbar" type="submit" name="websubmit" value="update_catalog">Update</button>
                                </div>
                                <table class="admint">
                                    <thead>
                                        <tr>
                                            <th class="checkcell"></th>
                                            <th><input class="ainputtext" readonly value="Title"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $catalogs as $catalog ) : ?>
                                        <tr>
                                            <td><input class="check" xname="check" onclick="oncheck(event, false)" type="checkbox"></td>
                                            <td><input disabled class="ainputtext" xname="uatitle" value='<?php echo $catalog['title']; ?>' ></td>
                                            <td style="display:none"><input xname="cid" value='<?php echo $catalog['id']; ?>' style="display:none"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td><input name="atitle" placeholder="Title for the Catalog" type="text" class="ainputtext"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="adminc">
                                    <div class="clearfix">
                                        <button type="submit" class="_52lq" name="websubmit" value="add_catalog" id="u_admin_review">Add Catalog</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <?php include('../footerview.php') ?>
        </div>
        <?php endif; ?>
    </body>
</html>