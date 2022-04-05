<?php
include("../dao/ProcessData.php");
    if(isset($_GET['id']))
    {
        $conn = new Database();
        $query = "select * from product where id = ?";
        $condition = [$_GET['id']];
        $result = $conn->selectParam($query,$condition);
        $product = $result->fetch(PDO::FETCH_ASSOC);
        if($_SERVER['REQUEST_METHOD']==='POST')
        {
            $id = $_GET['id'];
            if(isset($_POST['name']))
            {
                $query = "update product set name_pro = '{$_POST['name']}' where  id = ?";
                $condition = [$id];
                $conn->selectParam($query,$condition);
            }
            if(isset($_POST['price']))
            {
                $query = "update product set price = {$_POST['price']} where  id = ?";
                $condition = [$id];
                $conn->selectParam($query,$condition);
            }
            if(isset($_POST['description_pro']))
            {
                $query = "update product set description_pro = '{$_POST['description_pro']}' where  id = ?";
                $condition = [$id];
                $conn->selectParam($query,$condition);
            }
            if(isset($_POST['quantity']))
            {
                $query = "update product set quantity = {$_POST['quantity']} where  id = ?";
                $condition = [$id];
                $conn->selectParam($query,$condition);
            }

            if(isset($_POST['status']))
            {
                $checked = ($_POST['status']=="on")? 1:0;
                echo $_POST['status'];
                $query = "update product set status_pro = $checked where  id = ?";
                $condition = [$id];
                $conn->selectParam($query,$condition);
            }
            if($_FILES['img']['name']!='')
            {
                if(exif_imagetype($_FILES['img']['tmp_name'])) {
                    unlink("../image/${product['photo']}");
                    move_uploaded_file($_FILES['img']['tmp_name'], "../image/{$_FILES['img']['name']}");
                    $img_name = $_FILES['img']['name'];
                    $query = "update product set photo = '$img_name' where  id = ?";
                    $condition = [$id];
                    $conn->selectParam($query, $condition);
                    header("Location:about.php");
                }
                else
                {
                    echo '<script>';
                    echo "alert('Not is image');";
                    echo "window.location.href = 'edit.php?id={$product['id']}';";
                    echo '</script>';
                }
            }
        }
        $conn->closeConn();
    }
    else
    {
        header("Location:about.php");
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
                        <input type="text" class="form-control" value="<?php echo "${product['name_pro']}"?>" name="name">
                    </div>
                    <label for="price">Price</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo "${product['price']}"?>" name="price">
                    </div>
                    <label for="quantity">Quantity</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo "${product['quantity']}"?>" name="quantity">
                    </div>
                    <label for="description">Description</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <textarea name="description_pro"><?php echo "${product['description_pro']}"?></textarea>
                    </div>
                    <label for="photo">Photo</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <img src='../image/<?php echo"${product['photo']}" ?>' alt="" style="width: 309px;height: 183px" id="img">
                    </div>
                    <div class="input-group form-group">
                        <input type="file" name="img" class="input-group-prepend" onchange="changePicture()">
                    </div>
                    <label for="status">Status</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                        </div>
                        <input type="checkbox" class="form-control" <?php echo ($product['status_pro']) ?  "checked":"";?>>
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
<?php

?>
</body>
</html>
<script>
    function changePicture()
    {
        document.getElementById("img").src = URL.createObjectURL(event.target.files[0]);
    }
</script>