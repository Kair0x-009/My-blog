<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['isLogin']) == true) {
    header("Location: login.php");
    exit;
}

$isClicked = true;

$sql = "SELECT * FROM users ORDER BY user_id DESC";
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
                    <h3>Users List</h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($results) > 0) {
                            $i = 1;
                            while ($user = mysqli_fetch_assoc($results)) {

                        ?>
                                <tr>
                                    <th scope="row"><?= $i++ ?></th>
                                    <td>
                                        <?= $user['Full_name'] ?>
                                    </td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['phone'] ?></td>
                                    <td>
                                        <?php 
                                        if($user['status'] && $isClicked){
                                            echo "<button class='btn btn-success'>Active</button>";
                                        }else {
                                            echo "<button class='btn btn-danger'>Inactive</button>";
                                        }
                                        ?>
                                        
                                        
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