<?php
    $dsn = 'mysql:host=localhost;dbname=narasimh_decarato';
    $username = 'root';
    $password = '';
    $servername = "localhost";
    $dbname = "narasimh_decarato";

    $db = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (mysqli_connect_errno())
    {
        $error_message = mysqli_connect_error();
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        include('database_error.php');
        exit();
    }

    function logout() {
        // destroy the session 
        session_unset(); 
        session_destroy();
    }

    function get_users() {
        global $db;
        $query = "SELECT * FROM users";
        $users = $db->query($query);
        return $users;
    }

    function get_owners() {
        global $db;
        $query = "SELECT * FROM owner";
        $owners = $db->query($query);
        return $owners;
    }

    function get_owner($email) {
        if(!empty($email))
        {
            global $db;
            $query = "SELECT * FROM owner WHERE email = '$email'";
            $users = $db->query($query);
            $owner = mysqli_fetch_assoc($users);
            return $owner;
        }
    }

    function get_products() {
        global $db;
        $pquery = "SELECT * FROM product";
        $products = $db->query($pquery);
        return $products;
    }

    function get_catalogs() {
        global $db;
        $pquery = "SELECT * FROM category";
        $catalogs = $db->query($pquery);
        return $catalogs;
    }

    function get_products_cat($id) {
        global $db;
        $pquery = "SELECT * FROM product WHERE type = '$id'";
        $papers = $db->query($pquery);
        return $papers;
    }

    function get_products_owner($id) {
        global $db;
        $pquery = "SELECT * FROM product WHERE owneremail = '$id'";
        $products = $db->query($pquery);
        return $products;
    }

    function get_products_query($id) {
        global $db;
        $pquery = "SELECT * FROM product WHERE title LIKE '%$id%'";
        $papers = $db->query($pquery);
        return $papers;
    }

    function get_categories() {
        global $db;
        $pquery = "SELECT * FROM category";
        $papers = $db->query($pquery);
        return $papers;
    }

    function get_user_email_pass($email) {
        if(!empty($email))
        {
            global $db;
            $query = "SELECT password FROM users WHERE email = '$email'";
            $users = $db->query($query);
            $user = mysqli_fetch_assoc($users);
            return $user;
        }
    }

    function get_user($email) {
        if(!empty($email))
        {
            global $db;
            $query = "SELECT * FROM users WHERE email = '$email'";
            $users = $db->query($query);
            $user = mysqli_fetch_assoc($users);
            return $user;
        }
    }

    function get_cart($email) {
        global $db;
        $query = "SELECT * FROM cart WHERE useremail='$email'";
        $users = $db->query($query);
        return $users;
    }

    function add_user($fName, $pass, $lName, $email, $number, $address, $comOrg, $sex) {
        if(!empty($fName) && !empty($pass) && !empty($lName) && !empty($email) && !empty($number) && !empty($address) && !empty($comOrg) && !empty($sex))
        {
            global $db;
            $query = "INSERT INTO users
                    (fname, password, lname, email, number, address, company, sex)
                      VALUES
                    ('$fName', '$pass', '$lName', '$email', '$number', '$address', '$comOrg', '$sex')";
            $db->prepare($query)->execute();
        }
    }

    function get_admin_email_pass($email, $pass) {
        if((!empty($email) && !empty($pass)))
        {
            global $db;
            $query = "SELECT password, email FROM admin WHERE email = '$email' AND password = '$pass'";
            $users = $db->query($query);
            $user = mysqli_fetch_assoc($users);
            return $user;
        }
    }

    function get_owner_email_pass($email) {
        if((!empty($email)))
        {
            global $db;
            $query = "SELECT * FROM owner WHERE email = '$email'";
            $users = $db->query($query);
            $user = mysqli_fetch_assoc($users);
            return $user;
        }
    }

    function delete_pay($email, $cno) {
        if(!empty($email) && !empty($cno))
        {
            global $db;
            $query ="DELETE FROM paymentinfo WHERE useremail='$email' AND cardnumber='$cno'";
            $db->prepare($query)->execute();
        }
    }

    function add_card($uemail, $cno, $ctype, $cvv, $expiry) {
        if((!empty($uemail) && !empty($cno) && !empty($ctype) && !empty($cvv) && !empty($expiry)))
        {
            global $db;
            $query = "INSERT INTO paymentinfo
                (useremail, cardnumber, cardtype, cvv, expiry)
                      VALUES
                ('$uemail', '$cno', '$ctype', '$cvv', '$expiry')"; 
            $db->prepare($query)->execute();
        }
    }

    function delete_user($email) {
        if(!empty($email))
        {
            global $db;
            $query ="DELETE FROM users WHERE email='$email'";
            $db->prepare($query)->execute();
        }
    }

    function update_user($fname, $pass, $lname, $email, $number, $address, $attendee, $sex) {
        if((!empty($fname) && !empty($pass) && !empty($lname) && !empty($email) && !empty($number) && !empty($address) && !empty($attendee) && !empty($sex)))
        {
            global $db;
            $query = "UPDATE users SET fname = '$fname', attendee = '$attendee', lname = '$lname', password = '$pass', number = '$number', address = '$address', sex = '$sex' WHERE email = '$email' ";
            $db->prepare($query)->execute();
        }
    }

    function get_user_transaction($useremail) {
        if(!empty($useremail))
        {
            global $db;
            $rpquery = "SELECT * FROM transactions INNER JOIN userproduct ON userproduct.`transactionid` = transactions.`transactionid` INNER JOIN product ON product.`productid` = userproduct.`productid` WHERE transactions.`useremail`='$useremail'";
            $papers = $db->query($rpquery);
            return $papers;
        }
    }

    function get_user_pay($useremail) {
        if(!empty($useremail))
        {
            global $db;
            $rpquery = "SELECT * FROM paymentinfo WHERE paymentinfo.`useremail`='$useremail'";
            $papers = $db->query($rpquery);
            return $papers;
        }
    }

    function get_cart_details($useremail) {
        if(!empty($useremail))
        {
            global $db;
            $rpquery = "SELECT * FROM cart INNER JOIN product ON product.`productid` = cart.`productid` WHERE cart.`useremail`='$useremail'";
            $papers = $db->query($rpquery);
            return $papers;
        }
    }

    function get_user_cards($useremail) {
        if(!empty($useremail))
        {
            global $db;
            $rpquery = "SELECT cardnumber FROM paymentinfo WHERE paymentinfo.`useremail`='$useremail'";
            $papers = $db->query($rpquery);
            return $papers;
        }
    }

    function add_cart($proid, $uemail, $quantity) {
        if((!empty($proid) && !empty($uemail) && !empty($quantity)))
        {
            global $db;
            $query = "INSERT INTO cart
                (useremail, productid, quantity)
                      VALUES
                ('$uemail', '$proid', '$quantity')"; 
            $db->prepare($query)->execute();
        }
    }

    function add_product($title, $imagefile, $category, $price, $owneremail) {
        if((!empty($title) && !empty($imagefile) && !empty($owneremail) && !empty($category) && !empty($price)))
        {
            global $db;
            $query = "INSERT INTO product
                (title, imagefile, type, owneremail, price)
                      VALUES
                ('$title', '$imagefile', '$category',  '$owneremail', '$price')"; 
            $db->prepare($query)->execute();
        }
    }

    function delete_product($pid) {
        if((!empty($pid)))
        {
            global $db;
            $query = "DELETE FROM product WHERE productid = '$pid'"; 
            $db->prepare($query)->execute();
        }
    }

    function update_product($title, $imagefile, $category, $price, $owneremail, $pid) {
        if((!empty($title) && !empty($pid) && !empty($imagefile) && !empty($owneremail) && !empty($category) && !empty($price)))
        {
            global $db;
            $query = "UPDATE product SET title = '$title', imagefile = '$imagefile', type = '$category', owneremail = '$owneremail', price = '$price' WHERE productid = '$pid' ";
            $db->prepare($query)->execute();
        }
    }

    function add_catalog($title) {
        if((!empty($title)))
        {
            global $db;
            $query = "INSERT INTO category
                (title)
                      VALUES
                ('$title')"; 
            $db->prepare($query)->execute();
        }
    }

    function delete_catalog($cid) {
        if((!empty($cid)))
        {
            global $db;
            $query = "DELETE FROM category WHERE id = '$cid'"; 
            $db->prepare($query)->execute();
        }
    }

    function update_catalog($title, $cid) {
        if((!empty($title) && !empty($cid)))
        {
            global $db;
            $query = "UPDATE category SET title = '$title' WHERE id = '$cid' ";
            $db->prepare($query)->execute();
        }
    }

    function add_owner($fname, $lname, $email, $number, $address, $sex, $pass) {
        if((!empty($fname) && !empty($lname) && !empty($email) && !empty($number) && !empty($address) && !empty($sex) && !empty($pass)))
        {
            global $db;
            $query = "INSERT INTO owner
                (email, fname, lname, password, number, address, sex)
                      VALUES
                ('$email', '$fname', '$lname', '$pass', '$number', '$address', '$sex')";
            $db->prepare($query)->execute();
        }
    }

    function delete_owner($email) {
        if((!empty($email)))
        {
            global $db;
            $query = "DELETE FROM owner WHERE email = '$email'"; 
            $db->prepare($query)->execute();
        }
    }

    function update_owner($fname, $lname, $email, $number, $address, $sex, $pass) {
        if((!empty($fname) && !empty($lname) && !empty($email) && !empty($number) && !empty($address) && !empty($sex) && !empty($pass)))
        {
            global $db;
            $query = "UPDATE owner SET fname = '$fname', lname = '$lname', password = '$pass', number = '$number', address = '$address', sex = '$sex' WHERE email = '$email' ";
            $db->prepare($query)->execute();
        }
    }

    function delete_product_admin($pid) {
        if((!empty($pid)))
        {
            global $db;
            $query = "DELETE FROM product WHERE productid = '$pid'"; 
            $db->prepare($query)->execute();
        }
    }

    function update_product_admin($title, $imagefile, $category, $price, $owneremail, $pid) {
        if((!empty($title) && !empty($pid) && !empty($imagefile) && !empty($owneremail) && !empty($category) && !empty($price)))
        {
            global $db;
            $query = "UPDATE product SET title = '$title', imagefile = '$imagefile', type = '$category', owneremail = '$owneremail', price = '$price' WHERE productid = '$pid' ";
            $db->prepare($query)->execute();
        }
    }

    function delete_user_admin($email) {
        if((!empty($email)))
        {
            global $db;
            $query = "DELETE FROM users WHERE email = '$email'"; 
            $db->prepare($query)->execute();
        }
    }

    function update_user_admin($fname, $lname, $email, $number, $address, $sex, $pass, $company) {
        if((!empty($fname) && !empty($lname) && !empty($email) && !empty($number) && !empty($address) && !empty($sex) && !empty($pass) && !empty($company)))
        {
            global $db;
            $query = "UPDATE users SET fname = '$fname', password = '$pass', lname = '$lname', number = '$number', address = '$address', company = '$company', sex = '$sex' WHERE email = '$email' ";
            $db->prepare($query)->execute();
        }
    }

    function pay_transaction($paymentcard, $uemail) {
        if((!empty($paymentcard) && !empty($uemail)))
        {
            $usercart = get_cart_details($uemail);

            $total = 0;
            foreach ($usercart as $uc){
                $total = $total + ($uc["quantity"] * $uc["price"]);
            }
            global $db;
            $querytrans = "INSERT INTO transactions
                (useremail, totalprice, card)
                      VALUES
                ('$uemail', '$total', '$paymentcard')"; 
            $db->prepare($querytrans)->execute();
            $transactionid = mysqli_insert_id($db);
            
            foreach ($usercart as $uc){
                global $db;
                $quan = $uc["quantity"];
                $pid = $uc["productid"];
                $queryup = "INSERT INTO userproduct
                (useremail, productid, transactionid, quantity)
                      VALUES
                ('$uemail', '$pid','$transactionid' , '$quan')";
                $db->prepare($queryup)->execute();
            }

            global $db;
            $querydel = "DELETE FROM cart";
            $db->prepare($querydel)->execute();
        }
    }

    function delete_cart($email, $productid) {
        if(!empty($email) && !empty($productid))
        {
            global $db;
            $query ="DELETE FROM cart WHERE useremail='$email' AND productid='$productid'";
            $db->prepare($query)->execute();
        }
    }

    function update_cart($email, $productid, $quantity) {
        if((!empty($email) && !empty($productid) && !empty($quantity)))
        {
            global $db;
            $query = "UPDATE cart SET quantity = '$quantity' WHERE useremail = '$email' AND productid='$productid'";
            $db->prepare($query)->execute();
        }
    }
?>
