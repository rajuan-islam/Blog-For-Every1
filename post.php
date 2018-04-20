<?php
session_start();
require_once 'functions.php';
$user = new LoginRegistration();


if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
} else {
    $id = $_GET['id'];
}

if (!is_numeric($id)) {
    header('Location: index.php');
}

$check_if_post_exists = $user->check_if_post_exists($id);
if ($check_if_post_exists == FALSE) {
    header('Location: index.php');
    exit();
}
?>


<html>
    <head>
        <title>Full Content</title>
        <script src="../js/jquery.min.js"></script>


        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>


    <div class="content">

        <p class="login_msg">

        </p>
        <div class="index_post">

            <?php
            $getFullPost = $user->getFullPost($id);
            //print_r($getFullPost);
            foreach ($getFullPost as $fullPost) {
                ?>

                <h2 style="padding: 20px;width: 100% auto; background: ghostwhite; border-radius: 10px"><?php echo $fullPost['title']; ?></h2>
                <p style="text-align: center"><img src="<?php echo $fullPost['p_img_path']; ?>" height="300" width="400" alt="User Image Info" class="img-thumbnail"></p><br><br>
                <p style="font-style: italic"><?php echo $fullPost['content']; ?></p><br><br>
                <p style="font-style: oblique"><span style="color: #340099; font-weight: bold">Category:</span> <?php echo $fullPost['cat_name']; ?></p>
                <p style="font-style: oblique"><span style="color: #340099; font-weight: bold">Post Time:</span> <?php echo $fullPost['post_time']; ?></p>
                <p style="font-style: oblique"><span style="color: #340099; font-weight: bold">Author:</span> <?php echo $fullPost['username']; ?></p>
            <?php }
            ?>
            <br><br><hr><br><br>

            <p class="msg">
                <?php
                if (isset($_POST['comment_button'])) {
                    //$email = htmlentities($_POST['email'], ENT_QUOTES);
                    //$name = htmlentities($_POST['name'], ENT_QUOTES);
                    $comment = htmlentities($_POST['comment'], ENT_QUOTES);
                    $date = date('Y-m-d G:i:s');

                    if (empty($comment)) {
                        echo "<span style='color:e53d37'> Field must not be empty </span>";
                    } else {

                        if ($user->getSession()) {
                            $uid = $_SESSION['uid'];
                            $uname = $_SESSION['uname'];

                            $publish_comment = $user->publish_comment($id, $uid, $uname, $comment, $date);
                            if ($publish_comment) {
                                echo "<span style='color:green'> Comment Published....</span>";
                            } else {
                                echo "<span style='color:red'>Could not publish comment!!!</span>";
                            }
                        } else {
                            echo "<span style='color:e53d37'> You must be logged in to leave a comment... </span>";
                        }
                    }
                }
                ?>
            </p>

            <div class="post_reg">
                <h3 style="color: #e12727; text-align: center">Like to Leave A Comment?</h3><br>
                <form action="" method="post">
                    <table>  
                        <tr>
                            <td style="text-align: center">Comment:</td>
                            <td><textarea rows="4" cols="10" class="textarea" name="comment" placeholder="Put your comment here" required="">
                                        
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span style="float: right">
                                    <input type="submit" name="comment_button" value="Comment"/>
                                </span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <br><br><hr><br><br>
            <h3 style="color: #cc0033; text-align: center">All Comments So Far...</h3><br>
            <br><hr><br>


            <?php
            $allComments = $user->allComments($id);
            foreach ($allComments as $comments) {
                ?>
                <div class="cmnt">
                    <h4><?php echo strtoupper($comments['user_name']) . " said,"; ?></h4>
                    <blockquote><?php echo $comments['comment']; ?></blockquote>
                    <h5>at <?php echo $comments['comment_time']; ?></h5>
                </div><br>
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