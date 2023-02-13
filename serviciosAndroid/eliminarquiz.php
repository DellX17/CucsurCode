<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$codigo = $_POST['codigo'];
$query = "DELETE FROM `course_db`.`preguntas` WHERE quizid = '$codigo'";

$result = mysqli_query($conexion,$query);
if ($result) {
    echo "Datos eliminados";
}else {
    echo "error";
}

mysqli_close($conexion);
?>