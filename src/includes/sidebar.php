    <aside id="sidebar">
        <div id="sidebar-inner">
            <div id="top-part">
                <div id="pic">
                    <img src="assets/img/user.png" alt="user picture">
                </div>
                <div id="user-info">
                    <?php
                    // $eid=$_SESSION['eid'];
                    // $sql = "SELECT Name, Email from  tblemployees where EmpId=:eid";
                    // $query = $dbh -> prepare($sql);
                    // $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                    // $query->execute();
                    // $results=$query->fetchAll(PDO::FETCH_OBJ);
                    // $cnt=1;
                    // if($query->rowCount() > 0)
                    // {
                    // foreach($results as $result)
                    // {               ?>
                    <h6 class="user-name"><?php //echo htmlentities($result->Name); ?>hello</h6>
                    <span><?php //echo htmlentities($result->Email) ?>hello</span>
                    <?php //}} ?>
                </div>
            </div>
            <ul id="bottom-part">
                <li class="list">
                    <a class="links" href="profile.php">
                        <i class="material-icons link-icons">account_box</i>My
                        Profile
                    </a>
                </li>
                <li class="list">
                    <a class="links" href="change_password.php">
                        <i class="material-icons link-icons">lock</i>Change
                        Password
                    </a>
                </li>
                <li class="list">
                    <a class="links" href="products.php">
                        <i class="material-icons link-icons">list_alt</i>Products
                    </a>
                </li>
                <li class="list">
                    <a class="links" href="logout.php">
                        <i class="material-icons link-icons">logout</i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>