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
        <title>Update Profile</title>


        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>


    <div class="content">
        <h2>Update Your Profile</h2>
        <p class="msg">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userName = $_POST['username'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                if (empty($userName) or empty($name) or empty($email) or empty($phone)) {
                    echo "<span style='color:e53d37'> Field must not be empty </span>";
                } else {
                    $update = $user->updateUser($uid, $userName, $name, $email, $phone);
                    if ($update) {
                        echo "<span style='color:green; font-weight: bold'>Information Updated Successfully....</span>";
                    } else {
                        echo "<span style='color:red'>Update Failed!!!</span>";
                    }
                }
            }
            ?>
        </p>

        <?php
        $result = $user->getUserDetails($uid);
        foreach ($result as $row) {
            ?>

            <div class="login_reg">
                <form action="" method="post" name="reg">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" value="<?php echo $row['username']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" name="name" value="<?php echo $row['name']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="email" name="email" value="<?php echo $row['email']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td><input type="text" name="phone" value="<?php echo $row['phone']; ?>"/></td>
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
        <?php } ?>

        <div class="back">
            <a href="profile.php"><button class="button" style="vertical-align:middle"><span>Back   </span></button></a>
        </div>
    </div>

    <?php
    include("includes/footer.php");
    ?>
