
<?php

$conexion = mysqli_connect("localhost","root", "", "course_db");

$email = $_POST['correo'];
$pass =sha1($_POST['pass']);

$result = array();
$result['datos'] = array();
$query="SELECT * FROM `tutors` WHERE `email` = '$email' AND `password` = '$pass' LIMIT 1";

$response = mysqli_query($conexion,$query);

while($row= mysqli_fetch_array($response)){
    $result["tutor_id"]=$row['0'];
    $result["foto"]=$row['5'];
}

$result["exito"]="1";
echo json_encode($result);
mysqli_close($conexion);

?>