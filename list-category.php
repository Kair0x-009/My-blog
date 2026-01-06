<?php
    require 'connection.php';
    session_start();
    if (!$_SESSION['isLogin']===true) {
        header("Location: login.php");
    }

    $sql = "SELECT * from categories";
    $result = mysqli_query($conn , $sql);
    $i=1;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category-List</title>
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
            <div class="d-flex justify-content-between">
                <h3>Category List
                    <a href="create-category.php" class="btn btn-primary">Create Category</a></h3>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($result)){?>
                        <tr>
                            <td><?= $i++?></td>
                            <td><?=  $category['name']?></td>
                            <td><?=  $category['slug']?></td>
                            <td><a href="edit-category.php?id= <?=$category['ID'] ?> " class="btn btn-primary">Edit</a>
                                    <a href="delete-category.php?id= <?=$category['ID'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>