<?php
// session_start();
// error_reporting(0);
// include "includes/config.php";
// if(strlen($_SESSION['emplogin'])==0)
//     {
// header('location:index.php');
// }
// else{
// $eid=$_SESSION['emplogin'];
// if(isset($_POST['update']))
// {

// $fname=$_POST['firstName'];
// $lname=$_POST['lastName'];
// $gender=$_POST['gender'];
// $dob=$_POST['dob'];
// $department=$_POST['department'];
// $address=$_POST['address'];
// $city=$_POST['city'];
// $country=$_POST['country'];
// $mobileno=$_POST['mobileno'];
// $sql="update tblemployees set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Department=:department,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno where EmailId=:eid";
// $query = $dbh->prepare($sql);
// $query->bindParam(':fname',$fname,PDO::PARAM_STR);
// $query->bindParam(':lname',$lname,PDO::PARAM_STR);
// $query->bindParam(':gender',$gender,PDO::PARAM_STR);
// $query->bindParam(':dob',$dob,PDO::PARAM_STR);
// $query->bindParam(':department',$department,PDO::PARAM_STR);
// $query->bindParam(':address',$address,PDO::PARAM_STR);
// $query->bindParam(':city',$city,PDO::PARAM_STR);
// $query->bindParam(':country',$country,PDO::PARAM_STR);
// $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
// $query->bindParam(':eid',$eid,PDO::PARAM_STR);
// $query->execute();
// $msg="Employee record updated Successfully";
// }
$header_title="Profile";
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >
        <meta charset="UTF-8">
        <link href="assets/css/materialize.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/styles2.css" rel="stylesheet" type="text/css">
        <script src="assets/js/displayNavbar.js"></script>
    </head>

    <body>
        <?php include "includes/header.php"; ?>
        <?php include "includes/sidebar.php"; ?>
        <main class="main-inner">
            <div class="under-main-inner">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <form id="example-form" method="post" name="update_user">
                                <div>
                                    <h3>Update Profile</h3>
                                        <?php //if($error){?> 
                                        <!-- <div class="errorWrap"><strong>ERROR</strong>:<?php // echo htmlentities($error); ?> </div>
                                        <?php // } //else if($msg){ ?>
                                            <div class="succWrap"><strong>SUCCESS</strong> : <?php // echo htmlentities($msg); ?> </div><?php // } ?>> -->
                                    <section>
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php
                                                    // $eid=$_SESSION['emplogin'];
                                                    // $sql = "SELECT * from  tblemployees where EmailId=:eid";
                                                    // $query = $dbh -> prepare($sql);
                                                    // $query -> bindParam(':eid',$eid, PDO::PARAM_STR);
                                                    // $query->execute();
                                                    // $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    // $cnt=1;
                                                    // if($query->rowCount() > 0)
                                                    // {
                                                    // foreach($results as $result)
                                                    // {
                                                    ?>

                                                    <div class="input-field col s12">
                                                        <label for="Name">Name</label>
                                                        <input id="Name" name="Name" value="<?php
                                                        //echo htmlentities($result->Name);
                                                        ?>" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="Email">Email</label>
                                                        <input name="Email" type="Email" id="Email" value="<?php
                                                        //echo htmlentities($result->EmailId);
                                                        ?>" autocomplete="off" required>
                                                        <!-- <span id="emailid-availability" style="font-size:12px;"></span> -->
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="phone">Mobile number</label>
                                                        <input id="phone" name="mobileno" value="<?php
                                                        //echo htmlentities($result->Phonenumber);
                                                        ?>" autocomplete="off" maxlength="10" required>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="input-field col m6">
                                                <!-- <label for="birthdate">Date of Birth</label> -->
                                                <input id="birthdate" name="dob" type="date" placeholder="a" value="<?php
                                                //echo htmlentities($result->Dob);
                                                ?>" autocomplete="off">
                                            </div>

                                            <div class="input-field col m6">
                                                <label for="city">City/Town</label>
                                                <input id="city" name="city" value="<?php
                                                //echo htmlentities($result->City);
                                                ?>" autocomplete="off" required>
                                            </div>

                                            <div class="input-field col m6">
                                                <label for="country">Country</label>
                                                <input id="country" name="country" value="<?php
                                                //echo htmlentities($result->Country);
                                                ?>" autocomplete="off" required>
                                            </div>

                                            <?php
                                            //}}
                                            ?>

                                            <div class="input-field col s12">
                                                <button type="submit" name="update" id="update" class="update waves-effect">Update</button>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
<?php
//}
?>