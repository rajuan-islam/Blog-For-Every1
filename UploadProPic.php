<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];

if (!$user->getSession()) {
    header('Location: index.php');
    exit();
}
?>




<html>
    <head>
        <title>Update Profile Picture</title>

        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>


    <div class="content">
        <h2>Update Your Profile</h2>
        <p class="msg">
            <?php
            if (!empty($_POST)) {
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
                        ($_FILES["file_img"]["size"] < 1600000) &&
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

                            global $pdo;
                            $query = $pdo->prepare("UPDATE users SET u_img_name=? ,u_img_path=? ,u_img_type=? WHERE user_id =? ");
                            $query->execute(array($newfilename, $filepath, $filetype, $uid));
//                                    echo "Stored in: " . "photo/" . $_FILES["file_img"]["name"];
                            echo "<span style='color:green; font-weight: bold'>Information Updated Successfully....</span>";
                            ;
                        }
                    }
                } else {
                    echo "<span style='color:red'>Invalid File!!!</span>";
                }
            }
            ?>
        </p>

        <?php
        $result = $user->getUserDetails($uid);
        foreach ($result as $row) {
            ?>

            <div class="login_reg">
                <form action="" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Upload Profile Picture :</td>
                            <td><input type="file" name="file_img"/></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <span style="float: right">
                                    <input type="submit" name="btn_upload" value="Upload">
                                </span>
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
        <?php } ?>

        <div class="back">
            <a href="profile.php"><button class="button" style="vertical-align:middle"><span>Back   </span></button></a>
        </div>


        <?php
        include("includes/footer.php");
        ?>