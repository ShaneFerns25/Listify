<?php
session_start();
require_once "includes/config.php";

$response = verifyToken($_SESSION['id'], $_SESSION['token']);
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

$header_title = "Products";
$error="";
$msg= "";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Products</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <link href="assets/css/materialize.min.css" type="text/css" rel="stylesheet">
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/styles2.css" rel="stylesheet" type="text/css">
        <script src="assets/js/display-navbar.js"></script>
    </head>

    <body>
        <?php require_once "includes/header.php"; ?>
        <?php require_once "includes/sidebar.php"; ?>
        <main class="main-inner">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <?php if ($error) { ?> 
                                <div class="errorWrap displayError">
                                    <strong>ERROR</strong>: <?php echo $error; ?> 
                                </div>
                            <?php } else if ($msg) { ?>
                                <div class="succWrap displaySuccess">
                                    <strong>SUCCESS</strong>: <?php echo $msg; ?> 
                                </div>
                            <?php } ?>
                            <div class="errorWrap displayError clientSide">
                                <strong>ERROR</strong>: <?php echo $error; ?> 
                            </div>
                            <div class="succWrap displaySuccess clientSide">
                                <strong>SUCCESS</strong>: <?php echo $msg; ?> 
                            </div>
                            <div id="products">

                            <table id="products-table">
                            <thead>
                                <tr>
                                    <th>ProductID</th>
                                    <th>name</th>
                                    <th>description</th>
                                    <th>price</th>
                                    <th>category</th>
                                    <th>brand</th>
                                    <th>quantity</th>
                                    <th width="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $sql = "SELECT * FROM products";

                            $conn = getDbConnection();
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result){?>
                                <tr>
                                    <td><?php echo $result->ProductID; ?></td>
                                    <td><?php echo $result->name; ?></td>
                                    <td><?php echo $result->description; ?></td>
                                    <td><?php echo $result->price; ?></td>
                                    <td><?php echo $result->category; ?></td>
                                    <td><?php echo $result->brand; ?></td>
                                    <td><?php echo $result->quantity; ?></td>
                                    <td onclick="deleteRow(event)"><i class="material-icons delete-icon">delete_forever</i></td>
                                </tr>
                            <?php } }?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#products-table').DataTable({pageLength: 6});
            $('.dt-layout-row')[0].remove();
        });

        function deleteRow(event){
            let tdElement = event.srcElement.parentElement.parentElement.firstElementChild;
            let pid = parseInt(tdElement.textContent || tdElement.innerText, 10);
            console.log(pid);

            let errorWrap=$('.displayError');
            let successWrap=$('.displaySuccess');

            if (confirm("Are you sure you want to delete this row?")) {
                $.ajax({
                    url: "/Listify/delete-product",
                    type: 'post',
                    dataType: "json",
                    data: { Product_ID: pid},
                    success: function(response) {
                        console.log(response);
                        if (response.status=="error"){
                            errorWrap.css("display", "block");
                            errorWrap[0].childNodes[2].nodeValue = `: ${response.message}`;
                        }  else{
                            successWrap.css("display", "block");
                            successWrap[0].childNodes[2].nodeValue = `: ${response.message}`;
                            setTimeout(() => {
                                location.reload();
                            }, 2500);
                        }
                    },
                    error: function(error) {
                        console.error(error.responseJSON);
                        errorWrap.css("display", "block");
                        errorWrap[0].childNodes[2].nodeValue = `: ${error.responseJSON.message}`;
                    }
                });
            }
        }
    </script>
</html>