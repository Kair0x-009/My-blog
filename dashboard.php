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
        <?php include 'include/sidebar.php'; ?>
    </row>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>