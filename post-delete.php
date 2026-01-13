<?php
require 'connection.php';
$postID = $_GET['id'];
$sql = "SELECT * FROM post WHERE ID = '$postID'";
$results = mysqli_query($conn ,$sql);

if (mysqli_num_rows($results)>0) {
    $delete = "DELETE FROM post WHERE ID = '$postID'";
    if (mysqli_query($conn,$delete)===TRUE) {
        header("Location:post-list.php");
    }
}else {
    header("Location:post-list.php");
}
?>