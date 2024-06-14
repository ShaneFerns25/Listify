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

$error = "";
$msg = "";

if (isset($_POST['submit'])) {
    $name = isset($_POST['P_Name']) ? trim(filter_input(INPUT_POST, 'P_Name', FILTER_SANITIZE_STRING)) : '';
    $desc = isset($_POST['P_Desc']) ? trim(filter_input(INPUT_POST, 'P_Desc', FILTER_SANITIZE_STRING)) : '';
    $price = isset($_POST['P_Price']) ? trim(filter_input(INPUT_POST, 'P_Price', FILTER_SANITIZE_STRING)) : '';
    $category = isset($_POST['P_Category']) ? trim(filter_input(INPUT_POST, 'P_Category', FILTER_SANITIZE_STRING)) : '';
    $brand = isset($_POST['P_Brand']) ? trim(filter_input(INPUT_POST, 'P_Brand', FILTER_SANITIZE_STRING)) : '';
    $quantity = isset($_POST['P_Quantity']) ? trim(filter_input(INPUT_POST, 'P_Quantity', FILTER_SANITIZE_STRING)) : '';

    $sql = "INSERT INTO products(name,description,price,category,brand,quantity) VALUES(:name,:desc,:price,:category,:brand,:quantity)";
    					
    $conn = getDbConnection();
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':desc', $desc, PDO::PARAM_STR);
    $query->bindParam(':price', $price, PDO::PARAM_STR);
    $query->bindParam(':category', $category, PDO::PARAM_STR);
    $query->bindParam(':brand', $brand, PDO::PARAM_STR);
    $query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
    $query->execute();
    $lastInsertedId = $conn->lastInsertId();

    if ($lastInsertedId) {
        $msg = "New Product was added successfully";
    } else {
        $error = "An error has occurred. New Product was not added.";
    }
}

if (isset($_POST['update'])) {
    $p_id = isset($_POST['Update_P_ID']) ? trim(filter_input(INPUT_POST, 'Update_P_ID', FILTER_SANITIZE_STRING)) : '';
    $p_name = isset($_POST['Update_P_Name']) ? trim(filter_input(INPUT_POST, 'Update_P_Name', FILTER_SANITIZE_STRING)) : '';
    $p_desc = isset($_POST['Update_P_Desc']) ? trim(filter_input(INPUT_POST, 'Update_P_Desc', FILTER_SANITIZE_STRING)) : '';
    $p_price = isset($_POST['Update_P_Price']) ? trim(filter_input(INPUT_POST, 'Update_P_Price', FILTER_SANITIZE_STRING)) : '';
    $p_category = isset($_POST['Update_P_Category']) ? trim(filter_input(INPUT_POST, 'Update_P_Category', FILTER_SANITIZE_STRING)) : '';
    $p_brand = isset($_POST['Update_P_Brand']) ? trim(filter_input(INPUT_POST, 'Update_P_Brand', FILTER_SANITIZE_STRING)) : '';
    $p_quantity = isset($_POST['Update_P_Quantity']) ? trim(filter_input(INPUT_POST, 'Update_P_Quantity', FILTER_SANITIZE_STRING)) : '';

    $sql = "UPDATE products SET name=:p_name, description=:p_desc, price=:p_price, category=:p_category, brand=:p_brand, quantity=:p_quantity WHERE product_id=:p_id";
         
    $conn = getDbConnection();
    $query = $conn->prepare($sql);
    $query->bindParam(':p_name', $p_name, PDO::PARAM_STR);
    $query->bindParam(':p_desc', $p_desc, PDO::PARAM_STR);
    $query->bindParam(':p_price', $p_price, PDO::PARAM_STR);
    $query->bindParam(':p_category', $p_category, PDO::PARAM_STR);
    $query->bindParam(':p_brand', $p_brand, PDO::PARAM_STR);
    $query->bindParam(':p_quantity', $p_quantity, PDO::PARAM_STR);
    $query->bindParam(':p_id', $p_id, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $msg = 'Product updated successfully.';
    } else {
        $msg = 'No changes were made. Product is already up-to-date.';
    }
}

$header_title = "Products";
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
                                    <th>product_id</th>
                                    <th>name</th>
                                    <th>description</th>
                                    <th>price</th>
                                    <th>category</th>
                                    <th>brand</th>
                                    <th>quantity</th>
                                    <th width="1"></th>
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
                                foreach ($results as $result) { ?>
                                        <tr>
                                            <td><?php echo $result->product_id; ?></td>
                                            <td><?php echo $result->name; ?></td>
                                            <td><?php echo $result->description; ?></td>
                                            <td><?php echo $result->price; ?></td>
                                            <td><?php echo $result->category; ?></td>
                                            <td><?php echo $result->brand; ?></td>
                                            <td><?php echo $result->quantity; ?></td>
                                            <td onclick="updateRow(event)"><i class="material-icons update-icon modal-trigger" data-target="modal2">drive_file_rename_outline</i></td>
                                            <td onclick="deleteRow(event)"><i class="material-icons delete-icon">delete_forever</i></td>
                                        </tr>
                                <?php }
                            } ?>
                            <button class="waves-effect waves-light btn modal-trigger" data-target="modal1">Add</button>

                            <div id="modal1" class="modal">
                                <div class="modal-content">
                                    <h4>Add a Product</h4>

                                    <div class="row">
                                        <form method="post" class="col s12">
                                            <div class="row modal-form-row">
                                                <div class="input-field col s12">
                                                <input id="P_Name" name="P_Name" type="text" placeholder="Enter Product Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="P_Desc" name="P_Desc" type="text" placeholder="Enter Product Description">
                                                </div>
                                            </div>       
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="P_Price" name="P_Price" type="text" placeholder="Enter Product Price">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="P_Category" name="P_Category" type="text" placeholder="Enter Product Category">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="P_Brand" name="P_Brand" type="text" placeholder="Enter Product Brand">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="P_Quantity" name="P_Quantity" type="text" placeholder="Enter Product Quantity">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="submit" name="submit" class=" modal-action modal-close waves-effect waves-green btn-flat">Submit</button>
                                            </div>              
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="modal2" class="modal">
                                <div class="modal-content">
                                    <h4>Update Product</h4>

                                    <div class="row">
                                        <form method="post" class="col s12">
                                            <input type="hidden" id="Update_P_ID" name="Update_P_ID" value="">
                                            <div class="row modal-form-row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Name" name="Update_P_Name" type="text" placeholder="Enter Product Name" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Desc" name="Update_P_Desc" type="text" placeholder="Enter Product Description" value="">
                                                </div>
                                            </div>       
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Price" name="Update_P_Price" type="text" placeholder="Enter Product Price" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Category" name="Update_P_Category" type="text" placeholder="Enter Product Category" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Brand" name="Update_P_Brand" type="text" placeholder="Enter Product Brand" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <input id="Update_P_Quantity" name="Update_P_Quantity" type="text" placeholder="Enter Product Quantity" value="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="update" name="update" class=" modal-action modal-close waves-effect waves-green btn-flat">Update</button>
                                            </div>              
                                        </form>
                                    </div>
                                </div>
                            </div>
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
    <script src="assets/js/materialize.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#products-table').DataTable({pageLength: 6});
            $('.dt-layout-row')[0].remove();
        
            $('.modal').modal();
        });

        function deleteRow(event){
            let tdElement = event.srcElement.parentElement.parentElement.firstElementChild;
            let pid = parseInt(tdElement.textContent || tdElement.innerText, 10);
            console.log(pid);

            let errorWrap=$('.displayError');
            let successWrap=$('.displaySuccess');

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
                    }
                },
                error: function(error) {
                    console.error(error.responseJSON);
                    errorWrap.css("display", "block");
                    errorWrap[0].childNodes[2].nodeValue = `: ${error.responseJSON.message}`;
                }
            });
        }

        function updateRow(event) {
            let trChildren = event.srcElement.parentElement.parentElement.children;
            let arr = [...trChildren];
            let cnt = 0;
            let productInfoArr=[]

            for (let elem of arr.slice(0,7)){
                if (cnt==0 || cnt==3 || cnt==6) productInfoArr.push(parseInt(elem.textContent || elem.innerText, 10));
                else productInfoArr.push(elem.textContent || elem.innerText);
                cnt+=1
            }

            $('#Update_P_ID').val(productInfoArr[0]);
            $('#Update_P_Name').val(productInfoArr[1]);
            $('#Update_P_Desc').val(productInfoArr[2]);
            $('#Update_P_Price').val(productInfoArr[3]);
            $('#Update_P_Category').val(productInfoArr[4]);
            $('#Update_P_Brand').val(productInfoArr[5]);
            $('#Update_P_Quantity').val(productInfoArr[6]);
        }
    </script>
</html>