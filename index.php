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
        <title>Blog For Every1</title>

        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">

        <p class="login_msg">
        </p>

        <p class="userlist">All Blogs Are Presented here</p>
        <div class="index_post">
            <?php
            $allPost = $user->getAllPosts();
            //print_r($allPost);
            foreach ($allPost as $post) {
                $lastspace = strrpos($post['content'], ' ');
                ?>
                <article>
                    <h2><?php echo $post['title']; ?></h2><br>
                    <img class="image_style" src="<?php echo $post['p_img_path']; ?>" width="180" height="180" alt="User Image Info" class="img-thumbnail"><br><br><br>
                    <p><?php
                        $post_id = $post["post_id"];
                        echo substr($post['content'], 0, $lastspace) . " <a href='post.php?id=$post_id'> read more...</a>";
                        ?></p><br>
                    <p style="color: #006666"><?php echo $user->numOfComments( $post_id ); ?> comment(s) so far...</p>
                    <p><strong>Category:</strong> <font style="color: green"><?php echo $post['cat_name']; ?></font></p>
                    <p><strong>Time:</strong> <font style="color: #006666"><?php echo $post['post_time']; ?></font></p>
                    <p><strong>Author:</strong> <font style="color: blue; font-style: italic"><?php echo $post['username']; ?></font></p><br>
                </article>

                <br><hr><br>
            <?php }
            ?>

            <div class="page_button">
                <?php
//                        echo $prev." prev<br>";
//                        echo $page." page<br>";
//                        echo $pages." pages<br>";
                if ($prev > 0) {
//                            $prev = $_SESSION['prev'];
                    echo "<a style='color: #fffacd' href='index.php?p=$prev'>"
                    . "<div style='padding:10px; background: #9a0dea;border-radius: 5px;'>";
                    echo "Prev";
                    echo "</div></a><br>";
                }
                if ($page < $pages) {
//                            $next = $_SESSION['next'];

                    echo "<a style='color: #fffacd' href='index.php?p=$next'>"
                    . "<div style='padding:10px; margin-top:5px;  background: #9a0dea;border-radius: 5px;'>";
                    echo "Next";
                    echo "</div></a>";
                }
                ?>
            </div>

        </div>
    </div>


    <?php
    include("includes/footer.php");
    ?>