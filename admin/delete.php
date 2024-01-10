<?php
require '../config/config.php';
$stmt =$pdo->prepare("DELETE FROM post WHERE id=".$_GET['id']);
$result = $stmt->execute();
if($result){
    header("Location:index.php");
}
