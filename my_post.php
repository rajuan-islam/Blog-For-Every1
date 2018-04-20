<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();

if ($user->getSession()) {
    $uid = $_SESSION['uid'];
    $uname = $_SESSION['uname'];
}
?>



<html>
    <head>
        <title>User Posts</title>

        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">

        <p class="login_msg">
        </p>

        <p class="userlist">Posts of <?php echo $uname; ?></p>
        <div class="index_post">
            <?php
            $getAllUserPost = $user->getAllUserPost($uid);
            //print_r($getAllUserPost);
            foreach ($getAllUserPost as $userPost) {
                ?>
                <article>
                    <h2><?php echo $userPost['title']; ?></h2>
                    <p><img src="<?php echo $userPost['p_img_path']; ?>" height="200" width="200" alt="User Image Info" class="img-thumbnail"></p><br>
                    <p><?php echo $userPost['content']; ?></p><br>
                    <p><strong>Category:</strong> <font style="color: green"><?php echo $userPost['cat_name']; ?></font></p>
                    <p><strong>Time:</strong>  <font style="color: #006666"><?php echo $userPost['post_time']; ?></font></p>
                </article>
                <br><hr><br><br><br>
            <?php }
            ?>

        </div>

        <div class="back">
            <a href="profile.php"><button class="button" style="vertical-align:middle"><span>Back   </span></button></a>
        </div>
    </div>


    <?php
    include("includes/footer.php");
    ?>
