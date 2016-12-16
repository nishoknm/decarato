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
                $reviewer = get_reviewer_email_pass($email, $pass);
                $newemail = $reviewer['email'];
                $_SESSION["id"] = $newemail;
                $_SESSION["owner"] = $newemail;
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

            default:
                $location = $_SERVER["HTTP_REFERER"];
        }
    }
    $location = strpos($_SERVER["HTTP_REFERER"],'#') ? $_SERVER["HTTP_REFERER"] : $_SERVER["HTTP_REFERER"].$extender;
    header("Location: {$location}");
?>
