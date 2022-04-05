
<!DOCTYPE html>
<html>
<head>
    <title>Sign-Up</title>

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
                <h3>Sign-Up</h3>
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
                        <input type="text" class="form-control" placeholder="username" name="user-name" id="user-name">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="password" name="password">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sign-up" name = "sign-up" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    <a href="index.php"class="btn float-right login_btn">Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="button" value="click-me" id = "my-btn">
</body>
</html>
<?php
include("../dao/ProcessData.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new Database();
    if (isset($_POST['sign-up']) && isset($_POST['password']) && isset($_POST['user-name'])) {
        if (!empty(trim($_POST['user-name'])) && !empty(trim($_POST['password']))) {
            $query = "select * from account where user_name= ?";
            $condition = [$_POST['user-name']];
            $result = $conn->selectParam($query, $condition);
            if ($result->rowCount()) {
                echo "<script>
                          var user = document.getElementById('user-name');
                          user.value = 'Tên đăng nhập đã tồn tại';
                          user.style.cssText = 'background-color:red!important;color:black; font-weight:bold';
                        </script>";
                return;
            }
            $username = $_POST['user-name'];
            $password = md5($_POST['password']);
            $query = "insert into account(user_name, password) value ('{$username}','{$password}')";
            $result = $conn->select($query);
            if ($result) {
                echo "<script>  
                           var p = document.createElement('P');
p.innerText = 'Success to Sign-up';
p.style.cssText = 'font-size:50px;background-color:white;text-align:center';
var list = document.getElementsByClassName('card-body');
    for (var i = 0;i<list.length;i++)
    {
        list[i].innerHTML = '';
        list[i].appendChild(p);
    }
                      </script>";
            }
        } else {
            MessagePHP::showMessage("Vui lòng nhập tên đăng nhập và mật khẩu");
        }
    }
}
?>

