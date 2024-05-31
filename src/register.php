<?php
// include('includes/config.php');

    if(isset($_POST['submit']))
    {
        $name = $_POST['Name'];
        $shopid = $_POST['ShopID'];
        $pwd = md5($_POST['Password']);
        $sql = "SELECT Password FROM shop WHERE ShopID=:shopid";
        $query = $dbh -> prepare($sql);
        $query-> bindParam(':shopid', $shopid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() == 0){
        echo "Entered details are wrong. Enter proper details";
        }
        else{
        foreach($results as $row){
            if($row->Password == $pwd){
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
        <title>Listify Register</title>
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="assets/js/displayPass.js"></script>
    </head>

    <body>
        <div id="formback">
            <h2>Join <span>Listify</span>!</h2>
            <form action="#" method="post">
                <input id="Name" name="Name" type="text" placeholder="Enter Name" class="input_field" required><br>
                <input id="Email" name="Email" type="text" placeholder="Enter Email" class="input_field" required><br>
                <input id="Password" name="Password" type="password" placeholder="Enter Password" class="input_field" required><br>
                <i class="bi bi-eye-fill open-eye" onclick="showAndHidePass()"></i>
                <i class="bi bi-eye-slash-fill close-eye" onclick="showAndHidePass()"></i>
                <input id="ConfirmPass" name="ConfirmPass" type="password" placeholder="Confirm Password"  class="input_field" required><br>
                <i class="bi bi-eye-fill open-eye" onclick="showAndHidePass()"></i>
                <i class="bi bi-eye-slash-fill close-eye" onclick="showAndHidePass()"></i>
                <button class="register" name="submit" type="submit">Register</button><br>
                <h3>Already have an account? <a href="index.php">Login</a></h3>
            </form>
        </div>
    </body>
</html>