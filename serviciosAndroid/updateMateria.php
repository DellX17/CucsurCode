<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];


$query = "UPDATE playlist SET title ='$title', description ='$description' WHERE id = '$id'";

$result = mysqli_query($conexion,$query);
if ($result) {
    echo "Datos actualizados";
}else {
    echo "$query";
}
mysqli_close($conexion);
?>