<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $id = $_GET['get_id'];
}else{
   $id = '';
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

   $addquiz = $conn->prepare("INSERT INTO `preguntas`(id, tutor_id, pregunta ,opcion_a, opcion_b, opcion_c, correcta) VALUES(?,?,?,?,?,?,?)");
   $addquiz->execute([$id, $tutor_id, $pregunta, $opcion_a, $opcion_b, $opcion_c, $correcta]);
   $message[] = 'Nuevo ejercicio agregado!';
   header("location:quiz.php?get_id=$id");
   }


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nuevo ejercicio</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="video-form">

   <h1 class="heading">Crear nuevo ejercicio</h1>

   <form action="" method="post" enctype="multipart/form-data">
      
      
      <p>Ejercicio <span>*</span></p>
      <textarea name="pregunta" class="box" required placeholder="Cuerpo del ejercicio" maxlength="1000" cols="30" rows="10"></textarea>
     
      <p>Respuesta A <span>*</span></p>
      <input type="text" name="opcion_a" maxlength="100" required placeholder="Respuesta A" class="box">

      <p>Respuesta B <span>*</span></p>
      <input type="text" name="opcion_b" maxlength="100" required placeholder="Respuesta B" class="box">

      <p>Respuesta C <span>*</span></p>
      <input type="text" name="opcion_c" maxlength="100" required placeholder="Respuesta C" class="box">

      <p>Respuesta Correcta<span>*</span></p>
      <select name="correcta" class="box" required>
         <option value="" selected disabled>-- Selecciona una respuesta</option>
         <option value="A">A</option>
         <option value="B">B</option>
         <option value="C">C</option>
      </select>
      
      <input type="submit" value="Guardar ejercicio" name="submit" class="btn">
   </form>

</section>


<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>