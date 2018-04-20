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
        <title>Add Post</title>



        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">
        <h2>Add Post</h2>

        <p class="msg">
            <?php
            if (!empty($_POST)) {
                $title = htmlentities($_POST['title'], ENT_QUOTES);
                $categories = htmlentities($_POST['categories'], ENT_QUOTES);
                $content = htmlentities($_POST['content'], ENT_QUOTES);
                $date = date('Y-m-d G:i:s');

                if (empty($title) or empty($categories) or empty($content)) {
                    echo "<span style='color:e53d37'> Field must not be empty </span>";
                } else {
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $_FILES["file_img"]["name"]);
                    $extension = end($temp);

                    $filetype = $_FILES["file_img"]["type"];

                    if ((($filetype == "image/gif") ||
                            ($filetype == "image/jpeg") ||
                            ($filetype == "image/jpg") ||
                            ($filetype == "image/pjpeg") ||
                            ($filetype == "image/x-png") ||
                            ($filetype == "image/png")) &&
                            in_array($extension, $allowedExts)) {
                        if ($_FILES["file_img"]["error"] > 0) {
                            echo "Return Code: " . $_FILES["file_img"]["error"] . "<br>";
                        } else {

                            $fileName = $temp[0] . "." . $temp[1];
                            $temp[0] = rand(0, 3000); //Set to random number
                            $fileName;

                            if (file_exists("photo/" . $_FILES["file_img"]["name"])) {
                                echo $_FILES["file_img"]["name"] . " already exists. ";
                            } else {
                                $temp = explode(".", $_FILES["file_img"]["name"]);
                                $newfilename = round(microtime(true)) . '.' . end($temp);

                                $filetmp = $_FILES["file_img"]["tmp_name"];
                                $filepath = "photo/" . $newfilename;

                                move_uploaded_file($filetmp, $filepath);

                                $publish = $user->publishPost($categories, $title, $content, $uid, $date, $newfilename, $filepath, $filetype);

                                if ($publish) {
                                    echo "<span style='color:green'> Blog Published....</span>";
                                } else {
                                    echo "<span style='color:red'>Could not published Blog!!!</span>";
                                }
                            }
                        }
                    } else {
                        echo "<span style='color:red'>Invalid File!!!</span>";
                    }
                }
            }
            ?>
        </p>

        <div class="post_reg">
            <form action="" method="post" enctype="multipart/form-data">
                <table >    
                    <tr>
                        <td>Title:</td>
                        <td><input class="blog_title" type="text" name="title" placeholder="Title of Blog" required=""/></td>
                    </tr>
                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="categories" class="categories">
                                <option>--Select Categories--</option>
                                <option value="1">Uncategorised</option>
                                <option value="2">Personal</option>
                                <option value="3">Schools</option>
                                <option value="4">Non-profits</option>
                                <option value="5">Politics</option>
                                <option value="6">Military</option>
                                <option value="7">Private</option>
                                <option value="8">Sports</option>
                                <option value="9">How-to, tips and reviews</option>
                                <option value="10">SEO blogs</option>
                                <option value="11">Affiliate marketing blogs</option>
                                <option value="12">Book tour blogs</option>
                                <option value="13">Business</option>



                                //<?php
//                                        $getAllCategories = $user->getAllCategories();
//
//                                        foreach ($getAllCategories as $getAllCategory) {
//                                            echo "<option value='" . $getAllCategory['cat_id'] . "'>" . $getAllCategory['cat_name'] . "</option>";
//                                        }
//                                        
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Content:</td>
                        <td><textarea rows="4" cols="50" class="textarea" name="content" placeholder="Put your content here" required="">
                                    
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Upload Picture :</td>
                        <td><input type="file" name="file_img"/></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span style="float: right">
                                <input type="submit" name="publish" value="Publish"/>
                            </span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="back">
            <a href="profile.php"><button class="button" style="vertical-align:middle"><span>Back   </span></button></a>
        </div>
    </div>


    <?php
    include("includes/footer.php");
    ?>
