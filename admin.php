<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();

if ($user->getSession()) {
    header('Location: admin_home.php');
    exit();
}
?>

<html>
    <head>
        <title>Super Admin</title>

        <?php
        include("includes/header.php");
        ?>
            <div class="mainmenu">
                <ul>
                    <li><a href="index.php">home</a></li>
                </ul>
            </div>

            <div class="content">
                <h2 style="color: blue">Admin Panel</h2>

                <p class="msg">

                    <?php
                    $reEmail = "/^[a-z0-9\_\.]+\@[a-z0-9\-\.]+\.[a-z]{2,10}$/i";
                    $rePassword = '/^(?=.{8,})(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).*\\z/';
//                    8 characters, with at least one digit, one lower case letter and one upper case letter

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $email = htmlentities($_POST['email'], ENT_QUOTES);
                        $password = htmlentities($_POST['password'], ENT_QUOTES);

                        if (empty($email) or empty($password)) {
                            echo "<span style='color:e53d37'> Field must not be empty </span>";
                        } else {
                            $password = md5($password);

                            if (preg_match($reEmail, $email)) {
                                $loginAdmin = $user->loginAdmin($email, $password);

                                if ($loginAdmin) {
                                    header('Location: admin_home.php');
                                } else {
                                    echo "<span style='color:red'>Not in the Admin Panel!!!</span>";
                                }
                            } else {
                                $message = "Invalid Email...";
                            }
                        }
                    }
                    ?>
                </p>

                <div class="login_reg">
                    <form action="" method="post">
                        <table>  
                            <tr>
                                <td>Email:</td>
                                <td><input type="email" name="email" placeholder="email"/></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><input type="password" name="password" placeholder="password"/></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="float: right">
                                        <input type="submit" name="login" value="Login"/>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>


            <?php
            include("includes/footer.php");
            ?>
