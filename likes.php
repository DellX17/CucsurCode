<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

if(isset($_POST['remove'])){

   if($user_id != ''){
      $content_id = $_POST['content_id'];
      $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

      $verify_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
      $verify_likes->execute([$user_id, $content_id]);

      if($verify_likes->rowCount() > 0){
         $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
         $remove_likes->execute([$user_id, $content_id]);
         $message[] = 'Like removido';
      }
   }else{
      $message[] = 'es requerido que inicies sesión';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lecciones que te gustaron</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- courses section starts  -->

<section class="liked-videos">

   <h1 class="heading">Lecciones que te gustaron</h1>

   <div class="box-container">

   <?php
      $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
      $select_likes->execute([$user_id]);
      if($select_likes->rowCount() > 0){
         while($fetch_likes = $select_likes->fetch(PDO::FETCH_ASSOC)){

            $select_contents = $conn->prepare("SELECT * FROM `content` WHERE id = ? ORDER BY date DESC");
            $select_contents->execute([$fetch_likes['content_id']]);

            if($select_contents->rowCount() > 0){
               while($fetch_contents = $select_contents->fetch(PDO::FETCH_ASSOC)){

               $select_tutors = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutors->execute([$fetch_contents['tutor_id']]);
               $fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC);

               $thumbSOURCE = $fetch_contents['thumb'];
               if ($thumbSOURCE=="") {
               $thumbSOURCE="udg.png";
               }
   ?>
   <div class="box">
      <div class="tutor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_contents['date']; ?></span>
         </div>
      </div>
      <img src="uploaded_files/<?= $thumbSOURCE; ?>" alt="" class="thumb">
      <h3 class="title"><?= $fetch_contents['title']; ?></h3>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="content_id" value="<?= $fetch_contents['id']; ?>">
         <a href="watch_video.php?get_id=<?= $fetch_contents['id']; ?>" class="inline-btn">Ver lección</a>
         <input type="submit" value="Remover" class="inline-delete-btn" name="remove">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p class="emtpy">no se encontraron lecciones</p>';         
         }
      }
   }else{
      echo '<p class="empty">No le has dado like a ninguna lección</p>';
   }
   ?>

   </div>

</section>










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>