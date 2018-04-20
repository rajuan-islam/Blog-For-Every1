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
        <title>Registration Page</title>
        
        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>
        
    <div class="content">
        <h2>Register</h2>

        <p class="msg">
            <?php
            $reUserName = '/^[A-Za-z][A-Za-z0-9]{5,31}$/';
            $rePassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d!@#$%^&*._-]{8,}$/';
            $reName = "/^[a-z]+[a-z\ \.\-\']+$/i";
            $reEmail = "/^[a-z0-9\_\.]+\@[a-z0-9\-\.]+\.[a-z]{2,10}$/i";
            $rePhone = "/^[(+88)|(0088)|(88)]?[0-9\ \-]+$/";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userName = htmlentities($_POST['username'], ENT_QUOTES);
                $password = htmlentities($_POST['password'], ENT_QUOTES);
                $name = htmlentities($_POST['name'], ENT_QUOTES);
                $email = htmlentities($_POST['email'], ENT_QUOTES);
                $phone = htmlentities($_POST['phone'], ENT_QUOTES);



                if (empty($userName) or empty($password) or empty($name) or empty($email) or empty($phone)) {
                    echo "<span style='color:e53d37'> Field must not be empty </span>";
                } else {
                    $password = md5($password);

                    if (preg_match($reUserName, $userName)) {
                        if (preg_match($reName, $name)) {
                            if (preg_match($reEmail, $email)) {
                                if (preg_match($rePhone, $phone)) {
                                    $register = $user->registerUser($userName, $password, $name, $email, $phone);
                                    if ($register) {
                                        echo "<span style='color:green'> Registration done....<a href='login.php'>Click here</a> for Login!!! </span>";
                                    } else {
                                        echo "<span style='color:red'>Username or Password already exists!!!</span>";
                                    }
                                } else
                                    echo "Please Insert Valid phone";
                            } else
                                echo "Please Insert Valid Email";
                        } else
                            echo "Please Insert Valid Name";
                    } else
                        echo "Please Insert Valid Username";
                }
            }
            ?>
        </p>

        <div class="login_reg">
            <form action="" method="post">
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" placeholder="Username"/></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" placeholder="password"/></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name" placeholder="name"/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" placeholder="email"/></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="text" name="phone" placeholder="phone number"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span style="float: right">
                                <input type="submit" name="register" value="Register"/>
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