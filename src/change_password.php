<?php
require_once 'includes/config.php';
// if(strlen($_SESSION['emplogin'])==0)
//     {   
// header('location:index.php');
// }
// else{
// Code for change password 
// if(isset($_POST['change']))
//     {
// $password=md5($_POST['password']);
// $newpassword=md5($_POST['newpassword']);
// $username=$_SESSION['emplogin'];
//     $sql ="SELECT Password FROM tblemployees WHERE EmailId=:username and Password=:password";
// $query= $dbh -> prepare($sql);
// $query-> bindParam(':username', $username, PDO::PARAM_STR);
// $query-> bindParam(':password', $password, PDO::PARAM_STR);
// $query-> execute();
// $results = $query -> fetchAll(PDO::FETCH_OBJ);
// if($query -> rowCount() > 0)
// {
// $con="update tblemployees set Password=:newpassword where EmailId=:username";
// $chngpwd1 = $dbh->prepare($con);
// $chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
// $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
// $chngpwd1->execute();
// $msg="Your Password succesfully changed";
// }
// else {
// $error="Your current password is wrong";    
// }
// }
$header_title = "Change Password";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Change Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">
        <link href="assets/css/materialize.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/styles2.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/displayNavbar.js"></script>
    </head>

    <body>
        <?php require_once "includes/header.php"; ?>
        <?php require_once "includes/sidebar.php"; ?>
        <main class="main-inner">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <form class="col s12" name="change_pwd" method="post">
                                    <?php // if($error){ ?>
                                    <!-- <div class="errorWrap"><strong>ERROR</strong>:<?php // echo htmlentities($error); ?> </div>-->
                                    <?php  //} 
                                    // else if($msg){ ?>
                                    <!-- <div class="succWrap"><strong>SUCCESS</strong>:<?php // echo //htmlentities($msg); ?> </div><?php //} ?> -->
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" autocomplete="off"
                                                name="password" required>
                                            <label for="password">Current Password</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="newpassword" class="validate"
                                                autocomplete="off" required>
                                            <label for="password">New Password</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="confirmpassword" class="validate"
                                                autocomplete="off" required>
                                            <label for="password">Confirm Password</label>
                                        </div>


                                        <div class="input-field col s12">
                                            <button type="submit" name="change" class="reset-pass waves-effect">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
<?php //} ?>