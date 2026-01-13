<?php
    require 'connection.php';
    session_start();
    if (!$_SESSION['isLogin']===true) {
        header("Location: login.php");
    }

    $editID = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE ID = '$editID'";
    $result = mysqli_query($conn,$sql);
    $category = mysqli_fetch_assoc($result);

   if(isset($_POST['update'])){
        $name = $_POST['name'];
        $slug = $_POST['slug'];

        if (empty($name)&&empty($slug)) {
            $message = 'All fields Required';
            $msgType = 'danger';
        }else{
            $sql = "UPDATE categories SET name = '$name' , slug = '$slug' WHERE ID ='$editID' ";

            if(mysqli_query($conn,$sql)===TRUE){
                $message = 'Categories Updated Succesfully';
            $msgType = 'success';
            }
        }
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
<body>
 <?php include 'include/navbar.php'; ?>

 <div class="container my-5">
    <div class="row">
        <?php include 'include/sidebar.php'; ?>
        <div class="col-lg-9">
            <a href="list-category.php" class="btn btn-primary">All Category</a>
            <?php if(!empty($message)){?>
                <div class="alert w-100 mt-3 mx-auto alert-<?=$msgType?>">
                  <?= $message ?>
                </div>
                <?php } ?>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="edit-category.php?id=<?=$category['ID'] ?>" method="post">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="" class="form-control" value="<?= $category['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="" class="form-control" value="<?= $category['slug'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="" class="form-control" >
                        </div>
                        <button type="submit" class="btn btn-success" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>