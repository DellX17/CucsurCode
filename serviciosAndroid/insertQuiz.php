<?php
$tutor = $_POST['tutor'];
$Pregunta = $_POST['Pregunta'];
$Pa = $_POST['Pa'];
$Pb = $_POST['Pb'];
$Pc = $_POST['Pc'];
$Leccion = $_POST['Leccion'];
$Correcta = $_POST['Correcta'];


$connect = new PDO("mysql:host=localhost; dbname=course_db", "root", "");

$select_content = $connect->prepare("SELECT * FROM `content` WHERE title = ?");
      $select_content->execute([$Leccion]);
      if($select_content->rowCount() > 0){
    	while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
    	$Leccion = $fetch_content['id'];
		}
	}

session_start();

$data = array(
    ':tutor_id'			=>	$tutor,
	':id'			=>	$Leccion,
    ':pregunta'	=>	$Pregunta,
	':opcion_a'	=>	$Pa,
	':opcion_b'	=>	$Pb,
	':opcion_c'	=>	$Pc,
	':correcta'	=>	$Correcta
	
);

$query = "
INSERT INTO preguntas 
(id, pregunta, opcion_a, opcion_b, opcion_c, correcta, tutor_id) 
VALUES (:id, :pregunta, :opcion_a, :opcion_b, :opcion_c, :correcta, :tutor_id)
";
$statement = $connect->prepare($query);

$statement->execute($data);

echo 'Insertado';

?>