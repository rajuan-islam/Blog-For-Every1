<?php
session_start();
require_once "functions.php";
$user = new LoginRegistration();
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];
$utype = $_SESSION['utype'];

if (!$user->getSession()) {
    header('Location: admin.php');
    exit();
}

if (!empty($_GET['ban'])) {
    $ban_id = $_GET['ban'];
    $banUser = $user->banUser($ban_id);
}

if (!empty($_GET['act'])) {
    $act_id = $_GET['act'];
    $activateUser = $user->activateUser($act_id);
}

if (!empty($_GET['del'])) {
    $del_id = $_GET['del'];
    $deletePostFromAdminPanel = $user->deletePostFromAdminPanel($del_id);
}
?>




<html>
    <head>
        <title>Admin Panel</title>

        <?php
        include("includes/header.php");
        include("includes/nav.php");
        ?>

    <div class="content">

        <p class="login_msg">
            <?php
            if (isset($_SESSION['login_msg'])) {
                echo $_SESSION['login_msg'];
                unset($_SESSION['login_msg']);
            }
            ?>
        </p>

        <h2>Welcome, <font color="blue"><?php echo strtoupper($uname); ?></font><br><br>
            User Type : <font color="red"><?php echo strtoupper($utype); ?></font></h2>
        <br><br>
        <p class="userlist"> All User List</p>
        <hr><br>

        <table class="tbl_one">
            <tr>
                <th>Serial</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $i = 0;
            $allUser = $user->getAllUsers();
            foreach ($allUser as $users) {
                $i++;
                ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $users['name']; ?></td>
                    <td><?php echo $users['email']; ?></td>
                    <td><?php echo $users['type']; ?></td>
                    <td>
                        <?php
                        if ($users['status'] == 1) {
                            ?>
                            <div style="color: green">
                                <strong>Active</strong>
                            </div>
                            <?php
                        } elseif ($users['status'] == 0) {
                            ?>
                            <div style="color: red">
                                <strong> Inactive   </strong>
                            </div>
                            <?php
                        }
                        ?>

                    </td>
                    <td>
                        <?php
                        if ($users['status'] == 1) {
                            ?>
                            <div style="color: red">
                                <strong><a  onclick="return confirm('Are you sure?')" href="?ban=<?php echo $users['user_id']; ?>">Ban</a></strong>
                            </div>
                            <?php
                        } elseif ($users['status'] == 0) {
                            ?>
                            <div style="color: red">
                                <strong> <a onclick="return confirm('Are you sure?')" href="?act=<?php echo $users['user_id']; ?>">Activate</a></strong>
                            </div>
                            <?php
                        }
                        ?></td>
                </tr>
            <?php }
            ?>
        </table>



        <br><br><br>
        <p class="userlist">Delete User Posts</p>
        <hr><br>
        <table class="tbl_one">
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Title</th>
                <th>Category</th>
                <th>Content</th>
                <th>Action</th>

            </tr>

            <?php
            $i = 0;
            $allUserPosts = $user->allUserPost();
            foreach ($allUserPosts as $allUserPost) {
                $i++;
                ?>

                <tr>        
                    <td><?php echo $i; ?></td>
                    <td><?php echo $allUserPost['username']; ?></td>
                    <td><?php echo $allUserPost['email']; ?></td> 
                    <td><?php echo $allUserPost['title']; ?></td>
                    <td><?php echo $allUserPost['cat_name']; ?></td>
                    <td><?php echo $allUserPost['content'] . ' ...(more)'; ?></td>
                    <td><a onclick="return confirm('Are you sure?')" href="?del=<?php echo $allUserPost['post_id']; ?>">Delete</a></td> 
                    <?php
                }
                ?>
            </tr>



        </table> 

    </div>

    <?php
    include("includes/footer.php");
    ?>