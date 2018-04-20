<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    header("Location:index.php");
    exit();
}

if (!$user->getSession()) {
    header('Location: index.php');
    exit();
}
?>




<html>
    <head>
        <title>User Profile</title>

        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">

        <p class="login_msg">
        </p>

        <h2>Welcome, <?php echo $uname; ?></h2>

        <p class="userlist">User Profile Of : <?php $user->getUsername($id); ?></p>
        <table class="tbl_one">

            <?php
            $getUsers = $user->getUserById($id);
            foreach ($getUsers as $user) {
                ?>
                <tr>
                    <td>Profile Picture</td>
                    <td><img src="<?php echo $user['u_img_path']; ?>" height="300" width="400" alt="User Image Info" class="img-thumbnail"></td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td><?php echo $user['username']; ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $user['name']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php if ($user['user_id'] == $uid) { ?>
                    <tr>
                        <td>Update Profile</td>
                        <td><a href="update.php?id=<?php echo $user['id']; ?>">Edit Profile</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <div class="back">
            <a href="profile.php"><button class="button" style="vertical-align:middle"><span>Back   </span></button></a>
        </div>
    </div>


    <?php
    include("includes/footer.php");
    ?>