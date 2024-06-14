<?php
// session_start();
require_once 'includes/config.php';
require_once 'guzzle.php';

$error = '';
$msg = '';

if (isset($_POST['verify'])) {
    $isValid = true;
    $email = isset($_POST['Email']) ? trim(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL)) : '';
    // $regEmail = "/^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $error = '';
    $msg = '';

    if ((isset($_SESSION['submitted']) && $_SESSION['submitted'] < 1) || (!isset($_SESSION['submitted']))) {
        

        // if (empty($email) && $isValid) {
        //     $isValid = false;
        //     $error = 'Email is required.';
        // }

        // if ((strlen($email) < 6 || strlen($email) > 254) && $isValid) {
        //     $isValid = false;
        //     $error = 'Email should be between 6-254 characters.';
        // }

        // if (!preg_match($regEmail, $email) && $isValid) {
        //     $isValid = false;
        //     $error = 'Please enter a valid Email';
        // }

        // if (preg_match($regEmail, $email) && $isValid) {
        //     $res = postReqCheckEmailAvailability($client, $email);
        //     [$status, $message] = json_decode($res, true);
        //     if ($status != 'success') {
        //         $isValid = false;
        //         $error = $message;
        //     }
        // }

        if ($isValid) {

            // $token = bin2hex(random_bytes(64));

            $sql = "SELECT COUNT(*) as email_matched FROM users WHERE email=:email";

            $conn = getDbConnection();
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $result = $results[0];
            if ($result->email_matched > 0) {
                $msg = "Email was successfully verified";
                $unhide = 1;
                $moveToIndex=0;
            } else {
                $error = "An error has occurred. Email was not found";
            }
        }
    } else {
        $msg = 'Already Logged in';
    }
}

if (isset($_POST['reset'])) {
    $isValid = true;
    $email = isset($_POST['Verified_Email']) ? trim(filter_input(INPUT_POST, 'Verified_Email', FILTER_SANITIZE_EMAIL)) : '';
    $pwd = isset($_POST['Password']) ? trim(filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING)) : '';
    $cnpwd = isset($_POST['ConfirmPass']) ? trim(filter_input(INPUT_POST, 'ConfirmPass', FILTER_SANITIZE_STRING)) : '';
    // $regPass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,128}$/";
    $error = '';
    $msg = '';

    if ((isset($_SESSION['submitted']) && $_SESSION['submitted'] < 1) || (!isset($_SESSION['submitted']))) {

        // if (empty($pwd) && $isValid) {
        //     $isValid = false;
        //     $error = 'Password is required.';
        // }

        // if ((strlen($pwd) < 8 || strlen($pwd) > 128) && $isValid) {
        //     $isValid = false;
        //     $error = 'Password should be between 8-128 characters.';
        // }

        // if (!preg_match($regPass, $pwd) && $isValid) {
        //     $isValid = false;
        //     $error = 'Password should include an uppercase letter, a lowercase letter, a digit, and a special character.';
        // }

        // if (empty($cnpwd) && $isValid) {
        //     $isValid = false;
        //     $error = 'Confirm Password is required.';
        // }

        // if ((strlen($cnpwd) < 8 || strlen($cnpwd) > 128) && $isValid) {
        //     $isValid = false;
        //     $error = 'Confirm Password should be between 8-128 characters.';
        // }

        // if (!preg_match($regPass, $cnpwd) && $isValid) {
        //     $isValid = false;
        //     $error = 'Confirm Password should include an uppercase letter, a lowercase letter, a digit, and a special character.';
        // }

        if ($pwd != $cnpwd && $isValid) {
            $isValid = false;
            $error = 'Passwords do not match!';
        }

        if ($isValid) {
            $pwd = hash('sha3-512', $pwd);

            // $token = bin2hex(random_bytes(64));

            $sql = "UPDATE users SET password=:pwd WHERE email=:email";

            $conn = getDbConnection();
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            // $query->bindParam(':token', $token, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $msg = "Password was successfully resetted";
                $moveToIndex=1;
                
            } else {
                $error = "An error has occurred. Password was not resetted";
            }
        }
        $unhide = 1;
    } else {
        $msg = 'Already Logged in';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Listify Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/styles.css" rel="stylesheet" type="text/css">
        <script src="assets/js/display-pass.js"></script>
    </head>

    <body>
        <div id="formback">
            <?php if ($error) { ?> 
                <div class="errorWrap">
                    <strong>ERROR</strong>: <?php echo $error; ?> 
                </div>
            <?php } else if ($msg) { ?>
                <div class="succWrap">
                    <strong>SUCCESS</strong>: <?php echo $msg; ?> 
                </div>
            <?php if ($moveToIndex>0) header("refresh:3; url=index.php");} ?>
            <div class="errorWrap clientSide">
                <strong>ERROR</strong>:
            </div>
            <h2><?php echo((!isset($unhide)) ? "Let's verify your email!" : "Reset your password"); ?> </h2>
            <form id="registerForm" action="" method="post">
                <input type="hidden" id="Verified_Email" name="Verified_Email" value="<?php if (isset($email)) echo $email; ?>">
                <div class="<?php echo((isset($unhide)) ? "hidden" : ""); ?>">
                    <input id="Email" name="Email" type="text" placeholder="Enter Email" class="input_field" ><br>
                    <button class="verify" name="verify" type="submit">Verify</button><br>
                </div>
                <div class="<?php echo((!isset($unhide)) ? "hidden" : ""); ?>">
                    <input id="Password" name="Password" type="password" placeholder="Enter Password" class="input_field" ><br>
                    <i class="material-icons open-eye align" onclick="showAndHidePass()">visibility</i>
                    <i class="material-icons close-eye align" onclick="showAndHidePass()">visibility_off</i>
                    <input id="ConfirmPass" name="ConfirmPass" type="password" placeholder="Confirm Password" class="input_field" ><br>
                    <i class="material-icons open-eye2 align3" onclick="showAndHidePass2()">visibility</i>
                    <i class="material-icons close-eye2 align3" onclick="showAndHidePass2()">visibility_off</i>
                    <button class="reset" name="reset" type="submit">Reset</button><br>
                </div>
            </form>
        </div>
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <!-- <script src="assets/js/validate-forgot-pass.js"></script> -->
    </body>
</html>