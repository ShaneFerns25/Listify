<?php
// include('includes/config.php');
// if(strlen($_SESSION['emplogin'])==0)
//     {   
// header('location:index.php');
// }
// else{
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
        <script src="assets/js/displayNavbar.js"></script>
    </head>

    <body>
        <?php include "includes/header.php"; ?>
        <?php include "includes/sidebar.php"; ?>
        <main class="main-inner">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <!-- <?php //if($msg){ ?><div class="succWrap"><strong>SUCCESS</strong> : <?php //echo htmlentities($msg); ?> </div><?php //} ?> -->
                            <div id="products-table">
                                <iframe src="table.html" frameborder="0"></iframe>
                            </div>

                            <?php
                            // $eid=$_SESSION['eid'];
                            // $sql = "SELECT LeaveType,ToDate,FromDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status from tblleaves where empid=:eid";
                            // $query = $dbh -> prepare($sql);
                            // $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                            // $query->execute();
                            // $results=$query->fetchAll(PDO::FETCH_OBJ);
                            // $cnt=1;
                            // if($query->rowCount() > 0)
                            // {
                            // foreach($results as $result)
                            // {               ?>

                            <?php //echo htmlentities($cnt); ?>
                            <?php //echo htmlentities($result->LeaveType); ?>
                            <?php //echo htmlentities($result->FromDate); ?>
                            <?php //echo htmlentities($result->ToDate); ?>
                            <?php //echo htmlentities($result->Description); ?>
                            <?php //echo htmlentities($result->PostingDate); ?>
                            <?php //if($result->AdminRemark=="")
                            //                                             {
                            // echo htmlentities('waiting for approval');
                            //                                             } else
                            // {
                            
                            //  echo htmlentities(($result->AdminRemark)." "."at"." ".$result->AdminRemarkDate);
                            // }
                            
                            //                                             ?>
                            <?php //$cnt++;} } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
<?php // } ?>