<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();
$uid = $_SESSION['uid'];

if (!$user->getSession()) {
    header('Location: profile.php');
    exit();
}
?>




<html>
    <head>
        <title>Update Password</title>


        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">
        <h2>Update Your Profile</h2>
        <p class="msg">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];

                if (empty($old_password) or empty($new_password) or empty($confirm_password)) {
                    echo "<span style='color:e53d37'> Field must not be empty </span>";
                } else if ($new_password != $confirm_password) {
                    echo "<span style='color:red'>Password Missmatched!!!</span>";
                } else {
                    $new_password = md5($new_password);
                    $old_password = md5($old_password);

                    $passUpdate = $user->updatePassword($uid, $new_password, $old_password);
                }
            }
            ?>
        </p>

        <div class="login_reg">
            <form action="" method="post">
                <table>
                    <tr>
                        <td>Old Password :</td>
                        <td><input type="text" name="old_password" placeholder="Enter Old Password"/></td>
                    </tr>
                    <tr>
                        <td>New Password :</td>
                        <td><input type="text" name="new_password" placeholder="Enter New Password"/></td>
                    </tr>
                    <tr>
                        <td>Confirm New Password :</td>
                        <td><input type="text" name="confirm_password" placeholder="Confirm New Password"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span style="float: right">
                                <input type="submit" name="update" value="Update"/>
                                <input type="reset" value="Reset"/>
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