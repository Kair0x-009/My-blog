<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['isLogin']) == true) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM post ORDER BY id DESC";
$results = mysqli_query($conn, $sql);

// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'include/navbar.php';   ?>

    <div class="container my-5">
        <div class="row">
            <?php include 'include/sidebar.php';   ?>
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Post List</h3>
                    <a href="post-create.php" class="btn btn-primary">Create Post</a>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($results) > 0) {
                            $i = 1;
                            while ($post = mysqli_fetch_assoc($results)) {

                        ?>
                                <tr>
                                    <th scope="row"><?= $i++ ?></th>
                                    <td>
                                        <img width="100" src="uploads/post/<?= $post['image'] ?>" alt="">
                                    </td>
                                    <td><?= $post['title'] ?></td>
                                    <td><?= $post['slug'] ?></td>
                                    <td>
                                        <a href="post-edit.php?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="post-delete.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>