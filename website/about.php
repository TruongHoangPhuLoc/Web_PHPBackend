<?php include("../dao/ProcessData.php");
session_start();
$conn = new Database();
if(isset($_SESSION['user_name'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//        $query = "select * from product where id like :id"; //named
//        //$query = "select * from product where id like ? or name_pro like ?"; // unnamed
////        $condition = [
////                "%${_POST['id']}%",
////                "%${_POST['id']}%"
////
////        ];
//        $condition = ["id" => $_POST['id']];
//        //$query = "select * from product where concat(id,name_pro,price) like ?"
//        $result = $conn->selectParam($query, $condition);
        $query = "select * from product where concat(id,name_pro,price) like ?";

        $condition = ["%{$_POST['id']}%"];
        $result = $conn->selectParam($query,$condition);
    } else {
        $query = "select * from product";
        $result = $conn->select($query);
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("Location:index.php");
    }
}
else
{
    header("Location:index.php");
}
$conn->closeConn();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/about_style.css">
    <link rel="stylesheet" href="../bootstrap/fontawesome-free-5.15.2-web/fontawesome-free-5.15.2-web/css/all.css">

</head>
<body>
<form method="post">

    <!------ Include the above in your HEAD tag ---------->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <h1 class="nav-item nav-link active" style="color: wheat">Product</h1>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>


            <div class="custom-control-inline ml-auto">
                <div class="navbar-nav">
                    <a href="#" class="nav-item nav-link active">Search</a>
                </div>
                <input type="text" class="form-control mr-sm-2" placeholder="Enter some information about product..." name="id" style="width: 400px">
                <button type="submit" class="btn btn-outline-light">Search</button>
            </div>
        </div>
    </nav>

    <section class="jumbotron text-center">
        <div class="container">
	    <h3>Author</h3>
             <img style="height:200px;width:180px"src="../image/logo/88871833-8C33-482F-9AFE-1B892DD3143B.jpeg">
            <h1 class="jumbotron-heading">Manage Product</h1>
            <h3>User: <?php echo "{$_SESSION['user_name']}"?></h3>
        </div>
    </section>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-left">Product</th>
                            <th scope="col" class="text-center">Available</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-left">Description</th>
                            <th scope="col" class="text-center">CreateDate</th>
                            <th scope="col" class="text-center"> Delete </th>
                            <th scope="col" class="text-center"> Edit </th>
                            <th> </th>
                        </tr>
                        <?php
                        while ($product = $result->fetch(PDO::FETCH_ASSOC))
                        {
                            echo"<tr>";
                            echo"<td>${product['id']}</td>";
                            if($product['photo']!=null) {
                                echo "<td><img src='../uploaded_images/${product['photo']}'width='200px'/> </td>";
                            }
                            else
                            {
                                echo "<td class='text-center'>Not available image</td>";
                            }
                            echo" <td class='text-left'>${product['name_pro']}</td>";
                            if(!$product['status_pro'])
                            {
                                echo"<td class='text-center'>Out of stock</td>";
                            }
                            else
                            {
                                echo"<td class='text-center'>In stock</td>";
                            }
                            echo "<td class='text-center'>${product['quantity']}</td>";
                            echo " <td class='text-center'width='200px'>${product['price']}</td>";
                            echo"<td>${product['description_pro']}</td>";
                            echo"<td class='text-center'>${product['createdate']}</td>";
                            echo" <td class='text-center'><a class='btn btn-sm btn-danger' href='delete.php?id=${product['id']}'><i class='fa fa-trash'></i> </a> </td>";
                            echo "<td class='text-center'><a class='btn btn-sm btn-danger' href='edit.php?id=${product['id']}'><i class='fa fa-edit'></i> </a> </td>";
                            echo"</tr>";
                        }

                        ?>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a class="btn btn-lg btn-block btn-success text-uppercase" href="insert.php">Insert Product</a>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <input type="submit" name = "logout" class="btn btn-lg btn-block btn-success text-uppercase" value="CheckOut">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
