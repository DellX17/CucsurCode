<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$result = array();
$result['datos'] = array();


$query="SELECT * FROM `content`";

$response = mysqli_query($conexion,$query);

while($row= mysqli_fetch_array($response)){
    $index['id']=$row['0'];
    $index['clase']=$row['2'];
    $index['title']=$row['3'];
    $index['description']=$row['4'];
    $index['thumb']=$row['6'];
    array_push($result['datos'],$index);
}

$result["exito"]="1";
echo json_encode($result);
mysqli_close($conexion);

?>