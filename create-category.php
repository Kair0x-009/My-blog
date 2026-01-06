<?php
    require 'connection.php';
    session_start();
    if (!$_SESSION['isLogin']===true) {
        header("Location: login.php");
    }

   if(isset($_POST['save'])){
        $name = $_POST['name'];
        $slug = $_POST['slug'];

        if (empty($name)&&empty($slug)) {
            $message = 'All fields Required';
            $msgType = 'danger';
        }else{
            $sql = "INSERT INTO categories (name, slug) VALUES ('$name', '$slug')";

            if(mysqli_query($conn,$sql)===TRUE){
                $message = 'Categories Created Succesfully';
            $msgType = 'success';
            }
        }
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
<body>
 <?php include 'include/navbar.php'; ?>

 <div class="container my-5">
    <div class="row">
        <div class="col-lg-3">
            <ul class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="list-category.php" class="list-group-item list-group-item-action active">Categories</a>
                <a href="" class="list-group-item list-group-item-action">Posts</a>
                <a href="" class="list-group-item list-group-item-action">Users</a>
                <a href="" class="list-group-item list-group-item-action">Comments</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </ul>
        </div>
        <div class="col-lg-9">
            <a href="list-category.php" class="btn btn-primary">All Category</a>
            <?php if(!empty($message)){?>
                <div class="alert w-100 mt-3 mx-auto alert-<?=$msgType?>">
                  <?= $message ?>
                </div>
                <?php } ?>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="create-category.php" method="post">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success" name="save">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>