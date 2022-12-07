<?php
session_start();
include ("../dao/ProcessData.php");
if (isset($_GET['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = new Database();
        $id = $_GET['id'];
        if (isset($_POST['delete']))
        {
	    $slcpt = "select photo from product where id = :id";
            $query = "delete from product where id = :id";
            $condition=["id"=>$id];
	    $result = $conn->selectParam($slcpt, $condition);
	    $image = $result->fetch(PDO::FETCH_ASSOC);
	    shell_exec("rm -f /var/www/myphp/image/".$image['photo']);
            $flag = $conn->selectParam($query,$condition);
            if($flag)
            {  
                echo"<script>
                        alert('Delete successfully');
                        window.location.href = 'about.php';
                    </script>";
            }
            else
            {
                echo"<script>
                        alert('Something wrong when delete');
                        window.location.href = 'delete.php?id={$id}';
                    </script>";
            }
        }
        if(isset($_POST['cancel']))
        {
            header("Location:about.php");
        }
}
}
else
{
    header("Location:about.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="../bootstrap/fontawesome-free-5.15.2-web/fontawesome-free-5.15.2-web/css/all.css">
    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href=../css/changproduct.css>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<form action="" method="post">
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Delete</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body" >
                <h2 class="text-center">Are you sure to delete this product?</h2>
                <hr>
                <div class="form-group">
                    <input type="submit" value="Cancel" name = "cancel" class="btn float-right login_btn ml-3">
                    <input type="submit" value="Delete" name = "delete" class="btn float-right login_btn">
                </div>
        </div>
    </div>
</div>
</div>
</form>
</body>
</html>
