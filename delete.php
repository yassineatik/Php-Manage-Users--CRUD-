<?php


include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id = '$id'";
    $conn->exec($query);
    header('Location:admin.php');
}
