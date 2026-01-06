<?php
require 'connection.php';
$catID = $_GET['id'];
$sql = "SELECT * FROM categories WHERE ID = '$catID'";
$results = mysqli_query($conn ,$sql);

if (mysqli_num_rows($results)>0) {
    $delete = "DELETE FROM categories WHERE ID = '$catID'";
    if (mysqli_query($conn,$delete)===TRUE) {
        header("Location:list-category.php");
    }
}else {
    header("Location:list-category.php");
}
?>