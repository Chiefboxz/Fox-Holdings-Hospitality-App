<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="/lecafe/admin/index.php" class="navbar-brand">Admin page</a>
        <ul class="nav navbar-nav">            
            <!-- menue items -->
            <li><a href="ingredients.php">Ingredients</a></li>
            <li><a href="ingredientsUsed.php">Ingredients Used</a></li>
            <li><a href="Menu.php">Menu</a></li>
            <li><a href="archived.php">Archived</a></li>
            <?php if(has_permission('admin')) : ?>
            <li><a href="users.php">Users</a></li>
            <?php endif;?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                <li><a href="change_password.php">Change password</a></li>
                <li><a href="logout.php" >Logout</a></li>                 
                </ul>
            </li>
        </ul>
    </div>
</nav>