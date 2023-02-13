<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if($select_user->rowCount() > 0){
     setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:home.php');
   }else{
      $message[] = 'Datos incorrectos!';
   }

   if(isset($message)){
    foreach($message as $message){
      echo '<script type="text/javascript">
      window.onload = function () { alert("'.$message.'"); } 
</script>'; 
    }
 }
}

?>

<!DOCTYPE html>
<html lang="es" class="no-js">
<head>
  <meta charset="UTF-8">
  <title>CodeCucsur</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel="stylesheet" href="./style.css">
  
  <script src="js/modernizr.js"></script> <!-- Modernizr -->

</head>
<body class="loginAlumnosbody" style="padding-left: 0;">
  <main>
  <div class="cd-index cd-main-content">
    <div class="container" onclick="onclick">
      <div class="top"></div>
      <div class="bottom"></div>
      <div class="center">
        <div class="imgCont">
        <a href="admin/login.php"><img src="images/logoProfesores.png" alt="logo" class="logo"></a>
        <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
        <a href=""><img src="images/logoAlumnos.png" alt="logo" class="logo"></a>
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="login">
          <h2>Iniciar sesión</h2>
          <input type="email" name="email" placeholder="Email"/>
          <input type="password" name="pass" placeholder="Contraseña"/>
          <input type="submit" name="submit" value="Acceder" class="boton_primario">
        </form>
        <p class="register">No tienes una cuenta? <a href="register.php" data-type="page-transition"><span class="toRegister">Registrate</span></a></p>
      </div>
    </div>
  </div>
</main>

  <div class="cd-cover-layer"></div>
  <div class="cd-loading-bar"></div>
  <script src="js/jquery-2.1.1.js"></script>
  <script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>
