<?php
    require_once 'includes/config.php';
    if(isset($_POST['submit'])){
        $email = $_POST['Email'];
        $pwd = md5($_POST['Password']);
        $cnpwd = md5($_POST['ConfirmPass']);

        $sql = "SELECT * FROM shop WHERE ShopID =:shopid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':shopid',$shopid,PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
        foreach($results as $row) {
            if($row->Password == $pwd){
                if($cnpwd == $npwd){
                $sql = "UPDATE shop SET Password =:npwd WHERE ShopID =:shopid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':npwd',$npwd,PDO::PARAM_STR);
                $query->bindParam(':shopid',$shopid,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() == 0)
                {
                    $error="Password could not be changed. Please try again.";
                }
                else{
                    $msg="Password changed successfully.";
                }
              }
              else{
              $error="Entered confirm password doesn't match";
              }
            }
            else{
            $error="Enter the current password correctly";
            }
          }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Listify Forgot Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
        <script src="assets/js/displayPass.js"></script>
    </head>

    <body>
        <div id="formback">
            <h2>Let's verify your email!</h2>
            <form action="#" method="post">
                <input id="Email" name="Email" type="text" placeholder="Enter Email" class="input_field" required><br>
                <div class="hidden">
                    <input id="Password" name="Password" type="password" placeholder="Enter Password" class="input_field" required><br>
                    <i class="bi bi-eye-fill open-eye align" onclick="showAndHidePass()"></i>
                    <i class="bi bi-eye-slash-fill close-eye align" onclick="showAndHidePass()"></i>
                    <input id="ConfirmPass" name="ConfirmPass" type="password" placeholder="Confirm Password"  class="input_field" required><br>
                    <i class="bi bi-eye-fill open-eye2 align2" onclick="showAndHidePass2()"></i>
                    <i class="bi bi-eye-slash-fill close-eye2 align2" onclick="showAndHidePass2()"></i>
                </div>
                <button class="reset" name="submit" type="submit">Reset</button><br>
            </form>
        </div>
    </body>
</html>