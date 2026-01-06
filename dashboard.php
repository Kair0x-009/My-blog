<?php
    session_start();
    if (!$_SESSION['isLogin']===true) {
        header("Location: login.php");
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
<body>
 <?php include 'include/navbar.php'; ?>

 <div class="container my-5">
    <row>
        <div class="col-lg-3">
            <ul class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="list-category.php" class="list-group-item list-group-item-action">Categories</a>
                <a href="" class="list-group-item list-group-item-action">Posts</a>
                <a href="" class="list-group-item list-group-item-action">Users</a>
                <a href="" class="list-group-item list-group-item-action">Comments</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </ul>
        </div>
    </row>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>