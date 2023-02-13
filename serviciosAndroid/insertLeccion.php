<?php
$tutor = $_POST['tutor'];
$title = $_POST['title'];
$description = $_POST['description'];
$playlist_id = $_POST['playlist_id'];


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

$select_content = $connect->prepare("SELECT * FROM `playlist` WHERE title = ?");
      $select_content->execute([$playlist_id]);
      if($select_content->rowCount() > 0){
    	while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
    	$playlist_id = $fetch_content['id'];
		}
	}

$data = array(
    ':tutor_id'			=>	$tutor,
	':id'			=>	uniqid(),
    ':title'	=>	$title,
	':description'	=>	$description,
	':playlist_id'	=>	$playlist_id,
	':thumb'	=>	"udg.png",
	':status'	=>	"Activo"
);

$query = "
INSERT INTO content 
(id, tutor_id, playlist_id, title, description, thumb, status) 
VALUES (:id, :tutor_id, :playlist_id, :title, :description, :thumb, :status)
";
$statement = $connect->prepare($query);

$statement->execute($data);

echo 'Insertado';

?>