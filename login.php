<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();

if ($user->getSession()) {
    header('Location: profile.php');
    exit();
}
?>


<html>
    <head>
        <title>Login Page</title>
        
        
        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>
        
            <div class="content">
                <h2>Login</h2>

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
//                                if (preg_match($rePassword, $password)) {
                                $login = $user->loginUser($email, $password);

                                if ($login) {
                                    header('Location: profile.php');
                                } else {
                                    echo "<span style='color:red'>Username or Password does not match!!!</span>";
                                }
//                                } else {
//                                    $message = "Invalid Password, Use 8 characters, with at least one digit, one lower case letter and one upper case letter";
//                                }
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
