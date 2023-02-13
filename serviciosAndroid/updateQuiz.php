<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$Pregunta = $_POST['Pregunta'];
$Pa = $_POST['Pa'];
$Pb = $_POST['Pb'];
$Pc = $_POST['Pc'];
$Correcta = $_POST['Correcta'];

$quizid = $_POST['quizid'];

$query = "UPDATE preguntas SET pregunta ='$Pregunta', opcion_a ='$Pa', opcion_b = '$Pb', opcion_c = '$Pc', correcta = '$Correcta'  WHERE quizid = '$quizid'";

$result = mysqli_query($conexion,$query);
if ($result) {
    echo "Datos actualizados";
}else {
    echo "$query";
}
mysqli_close($conexion);
?>