<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['submitted'])) {
    $_SESSION['submitted'] = 0;
}

if (isset($_POST['login'])) {
    $isValid = true;
    $email = isset($_POST['Email']) ? trim(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL)) : '';
    $pwd = isset($_POST['Password']) ? trim(filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING)) : '';
    $regEmail = "/^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $regPass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,128}$/";
    $error = '';
    $msg = '';

    if ($_SESSION['submitted'] < 1) {

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

        if ($isValid) {
            $pwd = hash('sha3-512', $pwd);

            $token = bin2hex(random_bytes(64));

            $sql = "SELECT user_id FROM users WHERE email=:email AND password=:pwd";

            $conn = getDbConnection();
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() == 0) {
                $error = "Entered details are incorrect. Please try again.";
                $pwd = '';
            } else {
                $_SESSION['id'] = $results[0]->user_id;
                $_SESSION['token'] = $token;
                $_SESSION['submitted'] += 1;

                $sql = "UPDATE users SET token=:token WHERE user_id=:id";

                $conn = getDbConnection();
                $query = $conn->prepare($sql);
                $query->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
                $query->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $result_msg = 'Token updated successfully.';
                } else {
                    $result_msg = 'An error has occurred. The token could not be updated.';
                }

                echo "<script>console.log('Updation: " . $result_msg . "' );</script>";

                $msg = "Login Successful";
                $email = '';
                $pwd = '';
            }
        }
    } else {
        $msg = 'Already Logged in';
    }
} else {
    $email = '';
    $pwd = '';
    $error = '';
    $msg = '';
}
?>    

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Listify Login</title>
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
            <h2>Login to <span>Listify</span></h2>
            <form id="loginForm" action="<?php if ($_SESSION['submitted'] < 1)
                echo "javascript:void(0);" ?>" method="post">
                        <input id="Email" name="Email" type="text" placeholder="Enter Email" value="<?php if ($email)
                echo $email; ?>" class="input_field"><br>
                <input id="Password" name="Password" type="password" placeholder="Enter Password" value="<?php if ($pwd)
                    echo $pwd; ?>" class="input_field"><br>
                <i class="material-icons open-eye" onclick="showAndHidePass()">visibility</i>
                <i class="material-icons close-eye" onclick="showAndHidePass()">visibility_off</i>
                <a href="resetpass.php" class="reset">Forgot password?</a><br>
                <button class="login" name="login" type="submit">Login</button><br>
                <h3 class="create-acc">New to Listify? <a href="register.php">Create an account</a></h3>
            </form>
        </div>
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/validate-login.js"></script>
    </body>
</html>