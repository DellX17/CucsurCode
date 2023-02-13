<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$result = array();
$result['datos'] = array();
$tutor_id = $_POST['tutor_id'];


$query="SELECT * FROM `preguntas`";

$response = mysqli_query($conexion,$query);

while($row= mysqli_fetch_array($response)){
    $index['quizid']=$row['0'];
    $index['pregunta']=$row['2'];
    $index['opcion_a']=$row['3'];
    $index['opcion_b']=$row['4'];
    $index['opcion_c']=$row['5'];
    $index['correcta']=$row['6'];
    array_push($result['datos'],$index);
}

$result["exito"]="1";
echo json_encode($result);
mysqli_close($conexion);

?>