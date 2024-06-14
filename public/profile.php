<?php
session_start();
require_once "includes/config.php";
require_once 'guzzle.php';

$response=verifyToken($_SESSION['id'], $_SESSION['token']);
if (!$response['success']) {
    header('Location: logout.php');
} else {
    $name = $response['data']->name;
    $email = $response['data']->email;
    $mobile_number = $response['data']->mobile_number;
    $dob = $response['data']->dob;
    $town_or_city = $response['data']->town_or_city;
    $country = $response['data']->country;
}   

if (isset($_POST['update'])) {
    $isValid = true;
    $name = isset($_POST['Name']) ? trim(filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)) : '';
    $email = isset($_POST['Email']) ? trim(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL)) : '';
    $mobile_number = isset($_POST['Mobile_Number']) ? trim(filter_input(INPUT_POST, 'Mobile_Number', FILTER_SANITIZE_STRING)) : '';
    $dob = isset($_POST['Date_of_Birth']) ? trim(filter_input(INPUT_POST, 'Date_of_Birth', FILTER_SANITIZE_STRING)) : '';
    $town_or_city = isset($_POST['Town_or_City']) ? trim(filter_input(INPUT_POST, 'Town_or_City', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)) : '';
    $country = isset($_POST['Country']) ? trim(filter_input(INPUT_POST, 'Country', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)) : '';
    $regName = "/^[a-zA-Z\s'-]{1,100}$/";
    $regEmail = "/^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $regMobNo = "/^\d{10,15}$/";
    $regDOB = "/^\d{2}-\d{2}-\d{4}$/";
    $regTownOrCity = "/^[a-zA-Z\s\.'-]{2,50}$/";
    $regCountry = "/^[a-zA-Z\s\.'-]{2,50}$/";
    $error = '';
    $msg = '';

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

    if (preg_match($regEmail, $email) && $isValid) {
        if($email!=$response['data']->email){
            $res = postReqCheckEmailAvailability($client, $email);
            [$status, $message] = json_decode($res, true);
            if ($status != 'success') {
                $isValid = false;
                $error = $message;
            }
        }
    }

    if (!empty($mobile_number) && $isValid){
        if (!preg_match($regMobNo,$mobile_number) && $isValid) {
            $isValid = false;
            $error = "Mobile number must be numeric and between 10-15 digits.";
        }
    }

    if (!empty($dob) && $isValid){
        if (!preg_match($regDOB,$dob) && $isValid) {
            $isValid = false;
            $error = "Date of birth must be in DD-MM-YYYY format.";
        }
    }

    if (!empty($town_or_city) && $isValid){
        if ((strlen($town_or_city) < 2 || strlen($town_or_city) > 50) && $isValid) {
            $isValid = false;
            $error = "Town/City must be between 2-50 characters.";
        }

        if (!preg_match($regTownOrCity,$town_or_city) && $isValid) {
            $isValid = false;
            $error = "Town/City format is invalid.";
        }
    }

    if (!empty($country) && $isValid){
        if ((strlen($country) < 2 || strlen($country) > 50) && $isValid) {
            $isValid = false;
            $error = "Country must be between 2-50 characters.";
        }

        if (!preg_match($regCountry,$country) && $isValid) {
            $isValid = false;
            $error = "Country format is invalid.";
        }
    }

    if ($isValid) {
    
        $sql = "UPDATE users SET name=:name, email=:email, mobile_number=:mobile_number, dob=:dob, town_or_city=:town_or_city, country=:country WHERE user_id=:id";

        $conn = getDbConnection();
        $query = $conn->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile_number', $mobile_number, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':town_or_city', $town_or_city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $msg = 'Profile updated successfully.';
        } else {
            $msg = 'No changes were made. Your Profile is already up-to-date.';
        }
    }
} else {
    $error = '';
    $msg = '';
}

$header_title = "Profile";
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
            <script src="assets/js/display-navbar.js"></script>
        </head>

        <body>
            <?php require_once "includes/header.php"; ?>
            <?php require_once "includes/sidebar.php"; ?>
            <main class="main-inner">
                <div class="under-main-inner">
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <?php if ($error) { ?> 
                                    <div class="errorWrap">
                                        <strong>ERROR</strong>: <?php echo $error; ?> 
                                    </div>
                                <?php } else if ($msg) { ?>
                                    <div class="succWrap">
                                        <strong>SUCCESS</strong>: <?php echo $msg; ?> 
                                    </div>
                                <?php } ?>
                                <div class="errorWrap clientSide">
                                    <strong>ERROR</strong>:
                                </div>
                                <form id="updateForm" action="javascript:void(0);" method="post" name="update_user">
                                    <input type="hidden" id="Retrieved_Email" name="Retrieved_Email" value="<?php echo $response['data']->email; ?>">
                                    <input type="hidden" id="Message" name="Message" value="<?php echo $msg ?>">
                                    <div>
                                        <h3 class="h3-bold">Update Profile</h3>
                                        <section>
                                            <div class="row">
                                                <div class="col m6">
                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            <input id="Name" name="Name" type="text" placeholder="Enter Name" value="<?php echo $name?>" autocomplete="off">
                                                        </div>

                                                        <div class="input-field col s12">
                                                            <input name="Email" id="Email" type="text" placeholder="Enter Email" value="<?php echo $email?>" autocomplete="off">
                                                        </div>

                                                        <div class="input-field col s12">
                                                            <input id="Mobile_Number" name="Mobile_Number" type="text" placeholder="Enter Mobile Number" value="<?php if ($mobile_number) echo $mobile_number;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-field col m6">
                                                    <input id="Date_of_Birth" name="Date_of_Birth" class="datepicker" placeholder="Enter Date of Birth" value="<?php if ($dob) echo $dob;?>" autocomplete="off">
                                                </div>

                                                <div class="input-field col m6">
                                                    <input id="Town_or_City" name="Town_or_City" type="text" placeholder="Enter Town/City" value="<?php if ($town_or_city) echo $town_or_city;?>" autocomplete="off">
                                                </div>

                                                <div class="input-field col m6">
                                                    <input id="Country" name="Country" type="text" placeholder="Enter Country" value="<?php if ($country) echo $country;?>" autocomplete="off">
                                                </div>

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
            <script src="assets/js/jquery-3.7.1.min.js"></script>
            <script src="assets/js/materialize.min.js"></script>
            <script>
                $(document).ready(function(){
                    $('.datepicker').datepicker({format: 'dd-mm-yyyy'});
                    if($('#Message').val().trim() != ""){
                        setTimeout(() => {
                            $('.succWrap').css("display", "none");
                            $('.succWrap')[0].childNodes[2].nodeValue = "";
                        }, 5000);
                    }
                });
            </script>
            <script src="assets/js/validate-profile.js"></script>
        </body>
    </html>