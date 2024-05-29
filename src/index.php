<?php
// include('includes/config.php');

    if(isset($_POST['submit']))
    {
        $email = $_POST['Email'];
        $pass = md5($_POST['Password']);
        $sql = "SELECT Password FROM shop WHERE ShopID=:shopid";
        $query = $dbh -> prepare($sql);
        $query-> bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() == 0){
            echo "Entered details are wrong. Enter proper details";
        }
        else{
            foreach($results as $row){
                if($row->Password == $pass){
                    $_SESSION['shopid'] = $_POST['ShopID'];
                    echo "<script> window.location.assign('login_data.php'); </script>";
                }
                else{
                        echo "Entered details are wrong. Enter proper details.";
                }
            }
        }
    }
?>    

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Listify Login</title>
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="assets/js/displayPass.js"></script>
    </head>
    
    <body>
        <div id="formback">
            <h2>Login to <span>Listify</span></h2>
            <form action="#" method="post">
                <input id="Email" name="Email" type="text" placeholder="Enter Email" class="input_field" required><br>
                <input id="Password" name="Password" type="password" placeholder="Enter Password" class="input_field" required><br>
                <input type="checkbox" onclick="showpass()">Show Password
                <a href="https://www.google.com">Forgot password?</a><br>
                <button class="login" name="submit" type="submit">Login</button><br>
                <h3>New to Listify? <a href="register.php">Create an account</a></h3>
            </form>
        </div>
    </body>
</html>