<?php
session_start();
include ("../dao/ProcessData.php");
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $conn = new Database();
    if (isset($_POST['sign-in']) && isset($_POST['user-name']) && isset($_POST['password'])) {
        if (!empty($_POST['user-name'])&&!empty($_POST['password'])) {
            $user = $_POST['user-name'];
            $password = md5($_POST['password']);
            $query = "select * from account where user_name = ? AND password = ?";
            $condition = [
                "${user}",
                "${password}",
            ];
            $result = $conn->selectParam($query, $condition);
            if ($result->rowCount()==0) {
                MessagePHP::showMessage("Sai tên đăng nhập hoặc mật khẩu");
            }
            else {
                $_SESSION['user_name'] = $user;
                header("Location:about.php");
            }
        } else {
            MessagePHP::showMessage("Vui lòng điền tên đăng nhập và mật khẩu");
        }
    }
    $conn->closeConn();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="../bootstrap/fontawesome-free-5.15.2-web/fontawesome-free-5.15.2-web/css/all.css">
    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href=../css/login_style.css>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Sign In</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="username" name="user-name">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="password" name="password">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sign-in" name = "sign-in" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Don't have an account?<a href="sign_up.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
