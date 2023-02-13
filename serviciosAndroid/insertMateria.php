<?php
$tutor = $_POST['tutor'];
$title = $_POST['title'];
$description = $_POST['description'];


$connect = new PDO("mysql:host=localhost; dbname=course_db", "root", "");

function unique_id() {
	$str = '1234567890';
	$rand = array();
	$length = strlen($str) - 1;
	for ($i = 0; $i < 20; $i++) {
		$n = mt_rand(0, $length);
		$rand[] = $str[$n];
	}
	return implode($rand);
 }

$data = array(
    ':tutor_id'			=>	$tutor,
	':id'			=>	uniqid(),
    ':title'	=>	$title,
	':description'	=>	$description,
	':thumb'	=>	"udg.png",
	':status'	=>	"Activo"
);

$query = "
INSERT INTO playlist 
(id, tutor_id, title, description, thumb, status) 
VALUES (:id, :tutor_id, :title, :description, :thumb, :status)
";
$statement = $connect->prepare($query);

$statement->execute($data);

echo 'Insertado';

?>