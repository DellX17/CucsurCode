<?php
session_start();

include 'components/quizmotor.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
    $_SESSION['idCategoria'] = $_GET['get_id'];

}else{
    if($_SESSION['idCategoria']==""){
        $get_id = '';
        header('location:courses.php');
    }
}

$total_quiz = contarPreguntas($_SESSION['idCategoria']);


//Variables que contral la partida


if(isset($_GET['siguiente'])){//Ya esta jugando

    //Controlar si la respuesta esta bien
    if($_SESSION['respuesta_correcta']==$_GET['respuesta']){
        $_SESSION['correctas'] = $_SESSION['correctas'] + 1;
    }

    //
    $_SESSION['numPreguntaActual'] = $_SESSION['numPreguntaActual'] + 1;
    if($_SESSION['numPreguntaActual'] < ($total_quiz)){
        $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][ $_SESSION['numPreguntaActual']]);
        $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
    }else{
        //Lo enviamos al pagina de los resultados
        //Calculo la cantidad de respuestas incorrectas y lo guardo en una variable global
        $_SESSION['incorrectas'] = $total_quiz - $_SESSION['correctas'];
        //Obetengo el nombre de la categoria y lo ponogo en una variable global
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = ($_SESSION['correctas'] * 100)/$total_quiz;
        header("Location: final.php");
    }

}else{//comenzó a jugar
    $_SESSION['correctas']=0;
    $_SESSION['numPreguntaActual'] = 0;
    $_SESSION['preguntas'] = obtenerIdsPreguntasPorCategoria($_SESSION['idCategoria']);
    $_SESSION['idPreguntas'] = array();

    foreach ($_SESSION['preguntas'] as $idPregunta) {
        array_push($_SESSION['idPreguntas'],$idPregunta['quizid']); // Item agregado
    }
    
    //Desordeno el arreglo
    shuffle($_SESSION['idPreguntas']);
    $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][0]);
    $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios</title>
    <link rel="stylesheet" href="css/style_quiz.css?"<?php echo time(); ?>">
</head>
<body>
    <div class="container-juego" id="container-juego">
        <header class="header">
            <div class="categoria">
                <?php echo obtenerNombreTema($preguntaActual['id']) ?>
            </div>
            <a href="home.php">CucsurCode Alumnos</a>
        </header>
        <div class="info">
            <div class="estadoPregunta">
                Ejercicio <span class="numPregunta"><?php echo $_SESSION['numPreguntaActual'] + 1?></span> de <?php echo $total_quiz ?>
            </div>
            <textarea class="pregunta" cols="30" rows="5" readonly><?php echo $preguntaActual['pregunta']?> </textarea>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <div class="opciones">
                    <label for="respuesta1" onclick="seleccionar(this)" class="op1">
                        <p><?php echo $preguntaActual['opcion_a']?></p>
                        <input type="radio" name="respuesta" value="A" id="respuesta1" required>
                    </label>
                    <label for="respuesta2" onclick="seleccionar(this)" class="op2">
                        <p><?php echo $preguntaActual['opcion_b']?></p>
                        <input type="radio" name="respuesta" value="B" id="respuesta2" required>
                    </label>
                    <label for="respuesta3" onclick="seleccionar(this)" class="op3">
                        <p><?php echo $preguntaActual['opcion_c']?></p>
                        <input type="radio" name="respuesta" value="C" id="respuesta3" required>
                    </label>
                </div>
                <div class="boton">
                    <input type="submit" value="Siguiente" name="siguiente">
                </div>
            </form>
        </div>
    </div>
    <script>
        function seleccionar(labelSeleccionado) {
    var labels = document.getElementsByTagName("label");
    labels[0].className = "";
    labels[1].className = "";
    labels[2].className = "";

    labelSeleccionado.className = "opcionSeleccionada";

}

$(function() {
    $('.chart').easyPieChart({
        size: 160,
        barColor: "#36e617",
        scaleLength: 0,
        lineWidth: 15,
        trackColor: "#525151",
        lineCap: "circle",
        animate: 2000,
    });
});
    </script>
</body>
</html>