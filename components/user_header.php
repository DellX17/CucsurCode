<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">CucsurCode Alumnos</a>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="Busca una clase..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Estudiante</span>
         <a href="profile.php" class="btn">Revisar perfíl</a>
         
         <a href="components/user_logout.php" onclick="return confirm('Confirmar');" class="delete-btn">Cerrar sesión</a>
         <?php
            }else{
         ?>
         <h3>Inicia sesión o crea una cuenta</h3>
          <div class="flex-btn">
            <a href="index.php" class="option-btn">Crear cuenta</a>
            <a href="register.php" class="option-btn">Registrarse</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Estudiante</span>
         <a href="profile.php" class="btn">Ver perfíl</a>
         <?php
            }else{
         ?>
         <h3>Inicia sesión o registrate</h3>
          
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>Inicio</span></a>
      <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Clases</span></a>
      <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>Profesores</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>Reportar un bug</span></a>
      <a href="components/user_logout.php" onclick="return confirm('Confirmar');" ><i class="fas fa-right-from-bracket"></i><span>Cerrar sesión</span></a>
   </nav>

</div>

<!-- side bar section ends -->