<?php
session_start();
require_once 'includes/config.php';
require_once 'guzzle.php';
if(!isset($_SESSION['submitted'])){
    $_SESSION['submitted']=0;
}

if (isset($_POST['register'])) {
    $isValid = true;
    $name = isset($_POST['Name']) ? trim(filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)) : '';
    $email = isset($_POST['Email']) ? trim(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL)) : '';
    $pwd = isset($_POST['Password']) ? trim(filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING)) : '';
    $cnpwd = isset($_POST['ConfirmPass']) ? trim(filter_input(INPUT_POST, 'ConfirmPass', FILTER_SANITIZE_STRING)) : '';
    $regName = "/^[a-zA-Z\s'-]{1,100}$/";
    $regEmail = "/^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $regPass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,128}$/";
    $error = '';
    $msg = '';

    if($_SESSION['submitted']<1){
        
        if (empty($name) && $isValid) {
            $isValid = false;
            $error = 'Name is required.';
        }

        if (strlen($name) > 100 && $isValid) {
            $isValid = false;
            $error = 'Name should be less than 100 characters.';
        }
        
        if (!preg_match($regName, $name) && $isValid) {
            $isValid = false;
            
            $error = 'Name should only have alphabetic characters, spaces, hyphens, and apostrophes.';
        }

        if (empty($email) && $isValid) {
            $isValid = false;
            $error = 'Email is required.';
        }

        if ((strlen($email) < 6 || strlen($email) > 254) && $isValid) {
            $isValid = false;
            $error = 'Email should be between 6-254 characters.';
        }

        if (!preg_match($regEmail, $email) && $isValid) {
            $isValid = false;
            $error = 'Please enter a valid Email';
        }

        if (preg_match($regEmail, $email) && $isValid){
            $res=postReqCheckEmailAvailability($client,$email);
           [$status,$msg]=json_decode($res, true);
            if ($status!='success') {
                $isValid = false;
                $error = $msg;
            }
        }

        if (empty($pwd) && $isValid) {
            $isValid = false;
            $error = 'Password is required.';
        }

        if ((strlen($pwd) < 8 || strlen($pwd) > 128) && $isValid) {
            $isValid = false;
            $error = 'Password should be between 8-128 characters.';
        }

        if (!preg_match($regPass, $pwd) && $isValid) {
            $isValid = false;
            $error = 'Password should include an uppercase letter, a lowercase letter, a digit, and a special character.';
        }

        if (empty($cnpwd) && $isValid) {
            $isValid = false;
            $error = 'Confirm Password is required.';
        }

        if ((strlen($cnpwd) < 8 || strlen($cnpwd) > 128) && $isValid) {
            $isValid = false;
            $error = 'Confirm Password should be between 8-128 characters.';
        }

        if (!preg_match($regPass, $cnpwd) && $isValid) {
            $isValid = false;
            $error = 'Confirm Password should include an uppercase letter, a lowercase letter, a digit, and a special character.';
        }

        if ($pwd != $cnpwd && $isValid) {
            $isValid = false;
            $error = 'Passwords do not match!';
        }

        if ($isValid) {
            $pwd = hash('sha3-512', $pwd);

            $token = bin2hex(random_bytes(64));

            $sql = "INSERT INTO users(name,email,password,token) VALUES(:name,:email,:pwd,:token)";

            $conn = getDbConnection();
            $query = $conn->prepare($sql);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            $query->bindParam(':token', $token, PDO::PARAM_STR);
            $query->execute();
            $lastInsertedId = $conn->lastInsertId();

            if ($lastInsertedId) {
                $msg = "Registration Successful";
                $_SESSION['id'] = $lastInsertedId;
                $_SESSION['token'] = $token;
                $_SESSION['submitted'] += 1;
                $name = '';
                $email = '';
                $pwd = '';
                $cnpwd = '';
            } else {
                $error = "Something went wrong. Please try again";
            }
        }
    } else {
        $msg='Already Registered';
    }
} else {
    $name = '';
    $email = '';
    $pwd = '';
    $cnpwd = '';
    $error = '';
    $msg = '';
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
                <?php header("refresh:4; url=profile.php"); 
                } ?>
            <div class="errorWrap clientSide">
                <strong>ERROR</strong>:
            </div>
            <h2>Join <span>Listify</span>!</h2>
            <form id="registerForm" action="<?php if ($_SESSION['submitted'] < 1) echo "javascript:void(0);"?>" method="post">
                <input id="Name" name="Name" type="text" placeholder="Enter Name" value="<?php if ($name)
                    echo $name; ?>" class="input_field" ><br>
                <input id="Email" name="Email" type="text" placeholder="Enter Email" value="<?php if ($email)
                    echo $email; ?>" class="input_field" ><br>
                <input id="Password" name="Password" type="password" placeholder="Enter Password" value="<?php if ($pwd)
                    echo $pwd; ?>" class="input_field" ><br>
                <i class="material-icons open-eye align" onclick="showAndHidePass()">visibility</i>
                <i class="material-icons close-eye align" onclick="showAndHidePass()">visibility_off</i>
                <input id="ConfirmPass" name="ConfirmPass" type="password" placeholder="Confirm Password" value="<?php if ($cnpwd)
                    echo $cnpwd; ?>" class="input_field" ><br>
                <i class="material-icons open-eye2 align2" onclick="showAndHidePass2()">visibility</i>
                <i class="material-icons close-eye2 align2" onclick="showAndHidePass2()">visibility_off</i>
                <button class="register" name="register" type="submit">Register</button><br>
                <h3>Already have an account? <a href="index.php">Login</a></h3>
            </form>
        </div>
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/validate-register.js"></script>
    </body>
</html>