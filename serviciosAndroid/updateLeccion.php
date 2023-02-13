<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$playlist_id = $_POST['playlist_id'];



$query = "UPDATE content SET title ='$title',  description ='$description' WHERE id = '$id'";

$result = mysqli_query($conexion,$query);
if ($result) {
    echo "Datos actualizados";
}else {
    echo "$query";
}
mysqli_close($conexion);
?>