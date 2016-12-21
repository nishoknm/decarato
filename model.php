<?php

    session_start();
        
    // If valid, add the product to the database
    require_once('database.php');
    $extender = "";

    if(isset($_POST['websubmit']))
    { 
        $action = $_POST['websubmit'];
        switch ($action) {

            case "logout":
                logout();
                break;

            case "login":
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $user = get_user_email_pass($email);
                if(password_verify($pass, $user['password'])){
                    $_SESSION["id"] = $email;
                }
                break;

            case "signup":
                $fName = $_POST['fName'];
                $lName = $_POST['lName'];
                $email = $_POST['email'];
                $number = $_POST['number'];
                $address = $_POST['address'];
                $comOrg = $_POST['comOrg'];
                $pass = $_POST['password'];
                $sex = $_POST['sex'];
                add_user($fName, password_hash($pass, PASSWORD_DEFAULT), $lName, $email, $number, $address, $comOrg, $sex);
                $_SESSION["id"] = $email;
                break;

            case "owner_login":
                $email = $_POST['uname'];
                $pass = $_POST['pass'];
                $owner = get_owner_email_pass($email);
                if(password_verify($pass, $owner['password'])){
                    $newemail = $owner['email'];
                    $_SESSION["id"] = $newemail;
                    $_SESSION["owner"] = $newemail;
                }
                break;

            case "admin_logout":
                logout();
                break;

            case "admin_login":
                $email = $_POST['uname'];
                $pass = $_POST['pass'];
                $user = get_admin_email_pass($email, $pass);
                $newemail = $user['email'];
                $_SESSION["admin"] = $newemail;
                break;

            case "delete_pay":
                $email = $_POST['email'];
                $cardnumber = $_POST['ucno'];
                delete_pay($email, $cardnumber);
                $extender = "../signup";
                break;

            case "add_card":
                $uemail = $_POST['email']; 
                $cno = $_POST['cno'];
                if(is_numeric($cno))
                {
                    $cno = '';
                }
                $ctype = $_POST['ctype'];
                $cvv = $_POST['cvv'];
                $expiry = $_POST['expiry'];
                add_card($uemail, $cno, $ctype, $cvv, $expiry);
                $extender = "../signup";
                break;

            case "addcart":
                $proid = $_POST['proid'];
                $uemail = $_POST['email'];
                $quantity = 1;
                add_cart($proid, $uemail, $quantity);
                $extender = "../cart";
                break;

            case "selectcategory":
                $_SESSION["catid"] = $_POST['catid'];
                $_SESSION["qid"] = '';
                $extender = "../catalog";
                break;

            case "querycategory":
                $_SESSION["catid"] = '';
                $_SESSION["qid"] = $_POST['qid'];
                $extender = "../catalog";
                break;

            case "pay_transaction":
                $paymentcard = $_POST['paymentcard'];
                $uemail = $_POST['email'];
                pay_transaction($paymentcard, $uemail);
                $extender = "../greetings";
                break;

            case "delete_user":
                $email = $_POST['eemail'];
                delete_user($email);
                $extender = "#user";
                break;

            case "update_user":
                $fname = $_POST['efName'];
                $lname = $_POST['elName'];
                $email = $_POST['eemail'];
                $number = $_POST['enumber'];
                $address = $_POST['eaddress'];
                $sex = $_POST['esex'];
                $pass = $_POST['epassword'];
                $attendee = $_POST['eattendee'];
                update_user($fname, $pass, $lname, $email, $number, $address, $attendee, $sex);
                $extender = "#user";
                break;

            case "delete_cart":
                $email = $_POST['email'];
                $prodid = $_POST['prodid'];
                delete_cart($email, $prodid);
                $extender = "../cart";
                break;

            case "update_cart":
                $email = $_POST['email'];
                $prodid = $_POST['prodid'];
                $quantity = $_POST['quantity'];
                update_cart($email, $prodid, $quantity);
                $extender = "../cart";
                break;

            case "add_product":
                $title = $_POST['title'];
                $imagefile = $_POST['imagefile'];
                $price = $_POST['price'];
                $category = $_POST['type'];
                $owneremail = $_POST['email'];
                add_product($title, $imagefile, $category, $price, $owneremail);
                $extender = "../product";
                break;

            case "delete_product":
                $pid = $_POST['pid'];
                delete_product($pid);
                $extender = "../product";
                break;

            case "update_product":
                $title = $_POST['utitle'];
                $imagefile = $_POST['uimagefile'];
                $price = $_POST['uprice'];
                $category = $_POST['utype'];
                $owneremail = $_POST['email'];
                $pid = $_POST['pid'];
                update_product($title, $imagefile, $category, $price, $owneremail, $pid);
                $extender = "../product";
                break;

            case "add_catalog":
                $title = $_POST['atitle'];
                add_catalog($title);
                $extender = "#catalog";
                break;

            case "delete_catalog":
                $cid = $_POST['cid'];
                delete_catalog($cid);
                $extender = "#catalog";
                break;

            case "update_catalog":
                $title = $_POST['uatitle'];
                $cid = $_POST['cid'];
                update_catalog($title, $cid);
                $extender = "#catalog";
                break;

            case "add_owner":
                $fname = $_POST['fName'];
                $lname = $_POST['lName'];
                $email = $_POST['email'];
                $number = $_POST['number'];
                $address = $_POST['address'];
                $sex = $_POST['sex'];
                $pass = $_POST['password'];
                add_owner($fname, $lname, $email, $number, $address, $sex, password_hash($pass, PASSWORD_DEFAULT));
                $extender = "#owner";
                break;

            case "delete_owner":
                $email = $_POST['uemail'];
                delete_owner($email);
                $extender = "#owner";
                break;

            case "update_owner":
                $fname = $_POST['ufName'];
                $lname = $_POST['ulName'];
                $email = $_POST['uemail'];
                $number = $_POST['unumber'];
                $address = $_POST['uaddress'];
                $sex = $_POST['usex'];
                $pass = $_POST['upassword'];
                update_owner($fname, $lname, $email, $number, $address, $sex, $pass);
                $extender = "#owner";
                break;

            case "delete_product_admin":
                $pid = $_POST['pid'];
                delete_product_admin($pid);
                $extender = "#product";
                break;

            case "update_product_admin":
                $title = $_POST['utitle'];
                $imagefile = $_POST['uimagefile'];
                $price = $_POST['uprice'];
                $category = $_POST['utype'];
                $owneremail = $_POST['uowner'];
                $pid = $_POST['pid'];
                update_product_admin($title, $imagefile, $category, $price, $owneremail, $pid);
                $extender = "#product";
                break;

            case "delete_user_admin":
                $email = $_POST['eemail'];
                delete_user_admin($email);
                $extender = "#user";
                break;

            case "update_user_admin":
                $fname = $_POST['efName'];
                $lname = $_POST['elName'];
                $email = $_POST['eemail'];
                $number = $_POST['enumber'];
                $address = $_POST['eaddress'];
                $company = $_POST['ecompany'];
                $sex = $_POST['esex'];
                $pass = $_POST['epassword'];
                update_user_admin($fname, $lname, $email, $number, $address, $sex, $pass, $company);
                $extender = "#user";
                break;

            default:
                $location = $_SERVER["HTTP_REFERER"];
        }
    }
    $location = strpos($_SERVER["HTTP_REFERER"],'#') ? $_SERVER["HTTP_REFERER"] : $_SERVER["HTTP_REFERER"].$extender;
    header("Location: {$location}");
?>
