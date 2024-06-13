    <aside id="sidebar">
        <div id="sidebar-inner">
            <div id="top-part">
                <div id="pic">
                    <img src="assets/img/user.png" alt="user picture">
                </div>
                <div id="user-info">
                    <h6 id="user-name"><?php echo $response['data']->name; ?></h6>
                    <span><?php echo $response['data']->email; ?></span>
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