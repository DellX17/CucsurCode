<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:contents.php');
}

if(isset($_POST['submit'])){

   $pregunta = $_POST['pregunta'];

   $opcion_a = $_POST['opcion_a'];
   $opcion_a = filter_var($opcion_a, FILTER_SANITIZE_STRING);

   $opcion_b = $_POST['opcion_b'];
   $opcion_b = filter_var($opcion_b, FILTER_SANITIZE_STRING);

   $opcion_c = $_POST['opcion_c'];
   $opcion_c = filter_var($opcion_c, FILTER_SANITIZE_STRING);

   $correcta = $_POST['correcta'];
   $correcta = filter_var($correcta, FILTER_SANITIZE_STRING);

   $quizid = $_POST['quizid'];
   
   $aktualizar = $conn->prepare("UPDATE `preguntas` SET pregunta = ?, opcion_a = ?, opcion_b = ?, opcion_c = ?, correcta = ? WHERE quizid = ?");
   $aktualizar->execute([$pregunta, $opcion_a, $opcion_b, $opcion_c, $correcta, $quizid] );
   $message[] = 'Lección actualizada';  

}

if(isset($_POST['delete'])){
   $delete_id = $_POST['quizid'];
   $leccion=$_POST['id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $delete_playlist = $conn->prepare("DELETE FROM `preguntas` WHERE quizid = ?");
   $delete_playlist->execute([$delete_id]);
   header("location:quiz.php?get_id=$leccion");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Actualizar ejercicio</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="playlist-form">

   <h1 class="heading">Actualizar ejercicio</h1>

   <?php
         $pregunta_elegida = $conn->prepare("SELECT * FROM `preguntas` WHERE quizid = ?");
         $pregunta_elegida->execute([$get_id]);
         if($pregunta_elegida->rowCount() > 0){
         while($fetch_quiz = $pregunta_elegida->fetch(PDO::FETCH_ASSOC)){
      ?>

   <form action="" method="post" enctype="multipart/form-data">

      <p>Ejercicio <span>*</span></p>
      <textarea name="pregunta" class="box" required placeholder="Cuerpo de la lección" maxlength="1000" cols="30" rows="10"><?= $fetch_quiz['pregunta']; ?></textarea>

      <p>Respuesta A <span>*</span></p>
      <input type="text" name="opcion_a" maxlength="100" required placeholder="Respuesta A" value="<?= $fetch_quiz['opcion_a']; ?>" class="box">

      <p>Respuesta B <span>*</span></p>
      <input type="text" name="opcion_b" maxlength="100" required placeholder="Respuesta B" value="<?= $fetch_quiz['opcion_b']; ?>" class="box">

      <p>Respuesta C <span>*</span></p>
      <input type="text" name="opcion_c" maxlength="100" required placeholder="Respuesta C" value="<?= $fetch_quiz['opcion_c']; ?>" class="box">

      <p>Respuesta Correcta<span>*</span></p>
      <select name="correcta" class="box" required>
         <option value="<?= $fetch_quiz['correcta']; ?>" selected><?= $fetch_quiz['correcta']; ?></option>
         <option value="A">A</option>
         <option value="B">B</option>
         <option value="C">C</option>
      </select>

      <input type="hidden" name="quizid" value="<?= $fetch_quiz['quizid']; ?>">
      <input type="hidden" name="id" value="<?= $fetch_quiz['id']; ?>">

      <input type="submit" value="Actualizar" name="submit" class="btn">
      <div class="flex-btn">
         <input type="submit" value="Borrar" class="delete-btn" onclick="return confirm('Confirmar cambio');" name="delete">
      </div>
      <a href="quiz.php?get_id=<?= $fetch_quiz['id']; ?>" class="option-btn">Regresar</a>
   </form>

   <?php
      } 
   }else{
      echo '<p class="empty">Esta lección no existe!</p>';
   }
   ?>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>