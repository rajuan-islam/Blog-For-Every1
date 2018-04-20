<?php

require_once 'config.php';

class LoginRegistration {

    function __construct() {
        $database = new DatabaseConnection();
    }

    public function registerUser($userName, $password, $name, $email, $phone) {
        global $pdo;

        $status = 1;
        $type = 'user';
        $query = $pdo->prepare("SELECT user_id FROM users WHERE username = ? AND email = ?");
        $query->execute(array($userName, $email));
        $num = $query->rowCount();

        if ($num == 0) {
            $query = $pdo->prepare("INSERT INTO users(username, password, name, email, phone,type,status) VALUES(?, ?, ?, ?, ?,?,?)");
            $query->execute(array($userName, $password, $name, $email, $phone, $type, $status));
            return true;
        } else {
            return print "<span style='color:#e53d37'>Username/Email Already In Use....</span>";
        }
    }

    public function loginUser($email, $password) {
        global $pdo;
        $userType = 'user';
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND type = ? AND status = 1");
        $query->execute(array($email, $password, $userType));
        $userdata = $query->fetch();
        $num = $query->rowCount();

        if ($num == 1) {
            session_start();
            $_SESSION['login'] = TRUE;
            $_SESSION['uid'] = $userdata['user_id'];
            $_SESSION['uname'] = $userdata['username'];
            $_SESSION['login_msg'] = 'Logged in successfully...!!!';
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getSession(){
        return @$_SESSION['login'];
    }

    public function getUserType() {
        if ( $this->getSession() ) {
            $uid = $_SESSION['uid'];
            global $pdo;
            $query = $pdo->prepare("SELECT type FROM users WHERE user_id=?");
            $query->execute(array($uid));
            $userdata = $query->fetch();

            return $userdata['type'];
        }
    }

    public function getAllUsers() {

        global $pdo;
        $query = $pdo->prepare("SELECT * FROM users ORDER BY user_id DESC");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function getUsername($uid) {
        global $pdo;
        $query = $pdo->prepare("SELECT name FROM users WHERE user_id = ?");
        $query->execute(array($uid));
        $result = $query->fetch();
        echo strtoupper($result['name']);
    }

    public function getUserById($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $query->execute(array($id));
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function updateUser($uid, $userName, $name, $email, $website) {

        global $pdo;
        $query = $pdo->prepare("UPDATE users SET username=?, name=?, email=?, website=? WHERE user_id = ?");
        $query->execute(array($userName, $name, $email, $website, $uid));
        return true;
    }

    public function getUserDetails($userid) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM users WHERE user_id=?");
        $query->execute(array($userid));
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function updatePassword($uid, $new_password, $old_password) {

        global $pdo;
        $query = $pdo->prepare("SELECT user_id FROM users WHERE password=?");
        $query->execute(array($old_password));
        $num = $query->rowCount();

        if ($num == 0) {
            return print("<span style='color:red'>Old Password Doesn't Exist</span>");
        } else {
            $query = $pdo->prepare("UPDATE users SET password=? WHERE user_id=?");
            $query->execute(array($new_password, $uid));
            return print("<span style='color:green'>Successfull....!!!</span>");
        }
    }

    public function logOutUser() {
        $_SESSION['login'] = FALSE;
        unset($_SESSION['uid']);
        unset($_SESSION['uname']);
        session_destroy();
    }

    public function publishPost($categories, $title, $content, $uid, $date, $newfilename, $filepath, $filetype) {
        global $pdo;
        $query = $pdo->prepare("INSERT INTO posts(cat_id, title, content, user_id, post_time, p_img_name, p_img_path, p_img_type) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $query->execute(array($categories, $title, $content, $uid, $date, $newfilename, $filepath, $filetype));
        return true;
    }

    public function getAllPosts() {
        global $pdo, $per_page, $prev, $next, $page, $pages;
        $record_count = $pdo->prepare("select * from posts");
        $record_count->execute();
        $per_page = 2;
//        echo $record_count->rowCount();
        $pages = ceil($record_count->rowCount() / $per_page);

        if (isset($_GET['p']) && is_numeric($_GET['p'])) {
            $page = $_GET['p'];
        } else {
            $page = 1;
        }

        if ($page <= 0) {
            $start = 0;
        } else {
            $start = $page * $per_page - $per_page;
        }

        $prev = $page - 1;
        $next = $page + 1;

        $query = $pdo->prepare("SELECT *, LEFT(content, 100) AS content FROM posts NATURAL JOIN categories NATURAL JOIN users WHERE status = 1 ORDER BY post_id DESC limit $start,$per_page ");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function check_if_post_exists($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM posts WHERE post_id=?");
        $query->execute(array($id));
        if ($query->num_rows = 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getFullPost($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM posts NATURAL JOIN categories NATURAL JOIN users WHERE post_id=?");
        $query->execute(array($id));
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function publish_comment($id, $uid, $uname, $comment, $date) {
        global $pdo;
        $query = $pdo->prepare("INSERT INTO comments(post_id, user_id, user_name, comment, comment_time) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array($id, $uid, $uname, $comment, $date));
        return true;
    }

    public function allComments($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM comments WHERE post_id=? ORDER BY comment_id DESC");
        $query->execute(array($id));
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function getAllUserPost($uid) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM posts NATURAL JOIN users NATURAL JOIN categories WHERE user_id=? ORDER BY post_id DESC");
        $query->execute(array($uid));
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function loginAdmin($email, $password) {
        global $pdo;
        $userType = 'admin';
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND type = ?");
        $query->execute(array($email, $password, $userType));
        $userdata = $query->fetch();
        $num = $query->rowCount();

        if ($num == 1) {
            session_start();
            $_SESSION['login'] = TRUE;
            $_SESSION['uid'] = $userdata['user_id'];
            $_SESSION['uname'] = $userdata['name'];
            $_SESSION['utype'] = $userdata['type'];
            $_SESSION['login_msg'] = 'Logged in successfully...!!!';
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function banUser($ban_id) {
        global $pdo;
        $query = $pdo->prepare("UPDATE users SET status=0 WHERE user_id = ?");
        $query->execute(array($ban_id));
        return true;
    }

    public function activateUser($act_id) {
        global $pdo;
        $query = $pdo->prepare("UPDATE users SET status=1 WHERE user_id = ?");
        $query->execute(array($act_id));
        return true;
    }

    public function allUserPost() {
        global $pdo;
        $query = $pdo->prepare("SELECT *,LEFT(content, 60) AS content FROM posts NATURAL JOIN categories NATURAL JOIN users ORDER BY post_id DESC");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    public function deletePostFromAdminPanel($del_id) {
        global $pdo;
        $query = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
        $query->execute(array($del_id));
        return true;
    }

    public function getAllCategories() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM categories");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }
    
    
    public function numOfComments( $post_id ){
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM comments WHERE post_id = ?");
        $query->execute( array($post_id) );
        $userdata = $query->fetch();
        $num = $query->rowCount();
        return $num;
    }
    
    

}
