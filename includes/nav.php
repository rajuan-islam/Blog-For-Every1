<?php
require_once "functions.php";
$user = new LoginRegistration();
?>


<div class="mainmenu">
    <ul>
        <?php if ($user->getSession()) { ?>

            <?php if ($user->getUserType() == 'admin') { ?>

                <li><a href="index.php">home</a></li>
                <li><a href="admin_home.php">Admin Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="UploadProPic.php">Upload Profile Picture</a></li>
                <li><a href="changePassword.php">Change Password</a></li>
                <li><a href="add_post.php">Add Post</a></li>
                <li><a href="my_post.php">Admin Posts</a></li>
                <li><a href="logout.php">Logout</a></li>


            <?php } else if ($user->getUserType() == 'user') { ?>

                <li><a href="index.php">home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="UploadProPic.php">Upload Profile Picture</a></li>
                <li><a href="changePassword.php">Change Password</a></li>
                <li><a href="add_post.php">Add Post</a></li>
                <li><a href="my_post.php">All Posts</a></li>
                <li><a href="logout.php">Logout</a></li>

            <?php } 
            } else { ?>
            <li><a href="index.php">home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
    </ul>
</div>

