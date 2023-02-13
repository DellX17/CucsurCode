<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$result = array();
$result['datos'] = array();


$query="SELECT * FROM `playlist`";

$response = mysqli_query($conexion,$query);

while($row= mysqli_fetch_array($response)){
    $index['id']=$row['0'];
    $index['title']=$row['2'];
    $index['description']=$row['3'];
    $index['thumb']=$row['4'];
    array_push($result['datos'],$index);
}

$result["exito"]="1";
echo json_encode($result);
mysqli_close($conexion);

?>