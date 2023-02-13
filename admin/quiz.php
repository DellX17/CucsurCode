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

if(isset($_POST['delete'])){
    $delete_id = $_POST['quizid'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $delete_playlist = $conn->prepare("DELETE FROM `preguntas` WHERE quizid = ?");
    $delete_playlist->execute([$delete_id]);
    header("location:quiz.php?get_id=$get_id");
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ejercicios</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css?"<?php echo time(); ?>>

</head>
<body>
<?php include '../components/admin_header.php'; ?>

<section id="contents">
<h1 class="heading">Ejercicios de la lección</h1>

<a href="addqiz.php?get_id=<?= $get_id; ?>" class="btn"> Nuevo ejercicio</a>




<?php
      $select_content = $conn->prepare("SELECT * FROM `preguntas` WHERE id = ? AND tutor_id = ?");
      $select_content->execute([$get_id, $tutor_id]);
      if($select_content->rowCount() > 0){
        while($fetch_quiz = $select_content->fetch(PDO::FETCH_ASSOC)){
            ?>
                
                    <div class="contenedor-pregunta">
                        <div class="opciones">
                        <a href="update_quiz.php?get_id=<?= $fetch_quiz['quizid']; ?>" ><i class="fa-solid fa-pen-to-square"></i></a>
                        
                        
                                
                        </div>
                        <h3 class="pregunta"><?= nl2br($fetch_quiz['pregunta']); ?></h3>
                        <div class="opcion">
                            <div class="caja"  style="<?php if($fetch_quiz['correcta']=='A'){echo 'color:limegreen'; }?>">
                                A
                            </div>
                            <span class="texto"><?= $fetch_quiz['opcion_a']; ?></span>
                        </div>
                        <div class="opcion">
                            <span class="caja" style=" <?php if($fetch_quiz['correcta']=='B'){echo 'color:limegreen'; }?>">B</span>
                            <span class="texto"><?= $fetch_quiz['opcion_b']; ?></span>
                        </div>
                        <div class="opcion">
                            <span class="caja" style="<?php if($fetch_quiz['correcta']=='C'){echo 'color:limegreen'; }?>">C</span>
                            <span class="texto"><?= $fetch_quiz['opcion_c']; ?></span>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="quizid" value="<?= $fetch_quiz['quizid']; ?>">
                        <input type="submit" value="Borrar" class="delete-btn" onclick="return confirm('Confirmar cambio');" name="delete">
                        </form>
                    </div>
                    
        <?php
        }
    }else{
      echo '<p class="empty">No hay ejercicios!</p>';
    }
      
   ?>

</section>
                </div>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>


</body>
</html>