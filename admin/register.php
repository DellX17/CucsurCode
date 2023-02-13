<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
   $select_tutor->execute([$email]);
   
   if($select_tutor->rowCount() > 0){
      $message[] = 'Email en uso';
   }else{
      if($pass != $cpass){
         $message[] = 'Las contraseñas no coinciden';
      }else{
         $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
         $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         
         setcookie('tutor_id', $id, time() + 60*60*24*30, '/');
         header('location:dashboard.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registro de profesor</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/styleadmin.css">

</head>
<body style="padding-left: 0;"  class="cd-about">
<main>
		<div class="cd-about cd-main-content">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- register section starts  -->

<section class="form-container">

<link rel="stylesheet" href="../css/admin_style.css">
   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Nuevo registro de profesor</h3>
      <div class="flex">
         <div class="col">
            <p>Su nombre <span>*</span></p>
            <input type="text" name="name" placeholder="Escriba aquí su nombre" maxlength="50" required class="box">
            <p>Titulo preferido<span>*</span></p>
            <select name="profession" class="box" required>
               <option value="" disabled selected>-- Seleccione alguno</option>
               <option value="Señor">Señor</option>
               <option value="Señora">Señora</option>
               <option value="Licenciado">Licenciado</option>
               <option value="Licenciada">Licenciada</option>
               <option value="Ingeniero">Ingeniero</option>
               <option value="Ingeniera">Ingeniera</option>
               <option value="Doctor">Doctor</option>
               <option value="Doctora">Doctora</option>
               <option value="Profesor">Profesor</option>
               <option value="Profesora">Profesora</option>
               <option value="Maestro">Maestro</option>
               <option value="Maestra">Maestra</option>
            </select>
            <p>Su email <span>*</span></p>
            <input type="email" name="email" placeholder="Coloque aquí su email" maxlength="60" required class="box">
         </div>
         <div class="col">
            <p>Su contraseña <span>*</span></p>
            <input type="password" name="pass" placeholder="Escriba su contraseña" maxlength="20" required class="box">
            <p>Repita su contraseña <span>*</span></p>
            <input type="password" name="cpass" placeholder="Escriba de nuevo su contraseña" maxlength="20" required class="box">
            <p>Seleccione una foto de perfíl <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
         </div>
      </div>
      <p class="link">Ya tienes una cuenta? <a href="login.php" data-type="page-transition">inicia sesión</a></p>
      <input type="submit" name="submit" value="Completar registro" class="btn">
   </form>

</section>

<!-- registe section ends -->


<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
</div>
	</main>
	<div class="cd-cover-layer"></div>
	<div class="cd-loading-bar"></div>
<script src="js/jquery-2.1.1.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>