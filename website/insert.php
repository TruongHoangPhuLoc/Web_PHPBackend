<?php
include("../dao/ProcessData.php");
session_start();
if(isset($_SESSION['user_name']))
{
    if($_SERVER['REQUEST_METHOD']==="POST") {
        $conn = new Database();
        $name = "";
        $price = "";
        $description = "";
        $quantity = "";
        $status = "";
        $image = "";
        $date = "";
        if(isset($_POST['name']))
        {
            $name = $_POST['name'];
        }
        if(isset($_POST['price']))
        {
            $price = $_POST['price'];
        }
        if(isset($_POST['description_pro']))
        {
           $description = $_POST['description_pro'];
        }
        if(isset($_POST['quantity']))
        {
           $quantity = $_POST['quantity'];
           if($quantity)
           {
              $status = 1;
           }
           else
           {
               $status = 0;
           }
        }
        if($_FILES['img']['name']!='')
        {
		if(exif_imagetype($_FILES['img']['tmp_name'])){
		move_uploaded_file($_FILES['img']['tmp_name'],"/var/www/myphp/image/{$_FILES['img']['name']}");
                $image = $_FILES['img']['name'];

        	}
            else
            {
                echo '<script>';
                echo "alert('Not is image');";
                echo "window.location.href = 'insert.php';";
                echo '</script>';
            }
        }
        if(isset($_POST['date']))
        {
            $date = $_POST['date'];
        }
        $name = !empty($name)? "'$name'":"NULL";
        $price = !empty($price)? "'$price'":"NULL";
        $description = !empty($description)?"'$description'":"NULL";
        $quantity = !empty($quantity)?"'$quantity'":"NULL";
        $image = !empty($image)?"'$image'":"NULL";
        $status = !empty($status)?"'$status'":"NULL";
        $date = !empty($date)?"'$date'":"NULL";
        $query = "insert into product(name_pro, price, quantity, description_pro, photo, status_pro, createdate) values($name,$price,$quantity,$description,$image,$status,$date)";
        $flag = $conn->select($query);
        if(!$flag)
        {
            header("Location:insert.php");
        }
        else
        {
            header("Location:about.php");
        }
    }
}
else
{
    header("index.php");
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="../bootstrap/fontawesome-free-5.15.2-web/fontawesome-free-5.15.2-web/css/all.css">
    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href=../css/changproduct.css>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Edit Product</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Name</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-edit"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="enter name..." name="name" required>
                    </div>
                    <label for="price">Price</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="enter price..." name="price" required>
                    </div>
                    <label for="quantity">Quantity</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="enter quantity..." name="quantity" required onchange="changeStatus()">
                    </div>
                    <label for="description">Description</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <textarea name="description_pro">Enter description...</textarea>
                    </div>
                    <label for="photo">Photo</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <img src='' alt="" style="display: none" id="img">
                    </div>
                    <div class="input-group form-group">
                        <input type="file" name="img" class="input-group-prepend" onchange="changePicture()">
                    </div>
                    <label for="status">Status</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                        </div>
                        <input type="checkbox" class="form-control" name="status" id = "cbox" disabled>
                    </div>
                    <label for="date">Choose date</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                        </div>
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" name = "edit" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
<script>
    function changePicture()
    {
        var photo = document.getElementById("img");
        photo.src = URL.createObjectURL(event.target.files[0]);
        photo.style.cssText = "width: 309px;height: 183px;display:block";
    }
    function changeStatus()
    {
        var value = event.target.value;
        if(value!=0)
        {
            document.getElementById("cbox").checked = true;
        }
        else
        {
            document.getElementById("cbox").checked = false;
        }
    }
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("date").value = today;
</script>
