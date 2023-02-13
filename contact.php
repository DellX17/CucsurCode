<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number']; 
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg']; 
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if($select_contact->rowCount() > 0){
      $message[] = 'Mensaje ya enviado';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      $message[] = 'Gracias por tu reporte!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reporte de errores</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/bug.png" alt="">
      </div>

      <form action="" method="post">
         <h3>Reportanos un error</h3>
         <input type="text" placeholder="Tu nombre" required maxlength="100" name="name" class="box">
         <input type="email" placeholder="Tu correo" required maxlength="100" name="email" class="box">
         <input type="number" min="0" max="9999999999" placeholder="Tu teléfono" required maxlength="10" name="number" class="box">
         <textarea name="msg" class="box" placeholder="Error encontrado..." required cols="30" rows="10" maxlength="1000"></textarea>
         <input type="submit" value="Enviar mensaje" class="inline-btn" name="submit">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Teléfono de contacto</h3>
         <a href="tel:1171020542">+52 1 317 102 0542</a>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>Correo</h3>
         <a href="mailto:heriberto.chavez@alumnos.udg.mx">heriberto.chavez@alumnos.udg.mx</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Ubicación Cucsur</h3>
         <a href="#">Av Independencia Nacional 151</a>
      </div>


   </div>

</section>

<!-- contact section ends -->











<?php include 'components/footer.php'; ?>  

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>