<?php
session_start();


include 'components/quizmotor.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
  <link rel="stylesheet" href="css/style_quiz.css">
    <title>Ejercicios</title>
</head>
<body>
    <div class="container-final" id="container-final">
        <div class="info">
            <h2>RESULTADO FINAL Ejercicios de <span ><?php echo obtenerNombreTema($_SESSION['idCategoria']) ?></span></h2>
            <div class="estadistica">
                <div class="acierto">
                    <span class="correctas numero" > <?php echo $_SESSION['correctas'] ?></span>
                    CORRECTAS
                </div>
                <div class="acierto">
                    <span class="incorrectas numero" > <?php echo $_SESSION['incorrectas'] ?></span>
                    INCORRECTAS
                </div>
            </div>
            <div class="score">
                <div class="box">
                    <div class="chart" data-percent="<?php echo $_SESSION['score'] ?>">
                       <?php echo $_SESSION['score'] ?>%
                    </div>
                    <h2>Si no te agrada tu resultado <span><?php echo obtenerNombreAlumno($user_id) ?></span>, puedes repetir</h2>
                </div>
            </div>
            <button onclick="hacerReporte()" class="btn">Generar reporte</button>
            <a href="watch_video.php?get_id=<?= $_SESSION['idCategoria']; ?>">Regresar a la lección</a>

            <input type="hidden" id="correctas" value="<?php echo $_SESSION['correctas'] ?>">
            <input type="hidden" id="incorrectas" value="<?php echo $_SESSION['incorrectas'] ?>">
            <input type="hidden" id="clase" value="<?php echo obtenerNombreTema($_SESSION['idCategoria']) ?>">
            <input type="hidden" id="score" value="<?php echo $_SESSION['score'] ?>">
            <input type="hidden" id="alumno" value="<?php echo obtenerNombreAlumno($user_id) ?>">

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

    <script>
        function hacerReporte() {
            var correctas = document.getElementById('correctas').value;
            var incorrectas = document.getElementById('incorrectas').value;
            var clase = document.getElementById('clase').value;
            var score = document.getElementById('score').value;
            var alumno = document.getElementById('alumno').value;

            window.open("reporte.php?param1=" + correctas + "&param2=" + incorrectas + "&param3=" + clase + "&param4=" + score + "&param5=" + alumno );
        }
    </script>
</body>
</html>