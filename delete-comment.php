<?php
session_start();
require 'connection.php';
$cmtID = $_GET['id'];
$sql = "SELECT id , user_id FROM comments WHERE id = '$cmtID'";
$results = mysqli_query($conn ,$sql);

if (mysqli_num_rows($results)>0) {
    $row = mysqli_fetch_assoc($results);
    if ($row['user_id']!= $_SESSION['userId']) {
        header("Location: blog.php");
        exit();
    }

    $delete = "DELETE FROM comments WHERE id = '$cmtID'";
    if (mysqli_query($conn,$delete)===TRUE) {
        header("Location: blog.php");
    }
}else {
    echo "Comment Not Found";
}
?>