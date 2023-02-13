<?php

function obtenerNombreTema($id){
    include("components/conexion.php");
    $query = "SELECT * FROM content WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $tema = mysqli_fetch_array($result);
    
    return $tema['title'];
}

function obtenerNombreAlumno($id){
    include("components/conexion.php");
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_array($result);
    
    return $user['name'];
}

function obetenerTodasLasPreguntas()
{
    include("components/conexion.php");
    $query = "SELECT * FROM preguntas";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerPreguntaPorId($id){
    include("components/conexion.php");
    $query = "SELECT * FROM preguntas WHERE quizid = $id";
    $result = mysqli_query($conn, $query);
    $pregunta = mysqli_fetch_array($result);
    return $pregunta;
}

function obtenerTotalPreguntas(){
    include("components/conexion.php");
    //Añadimos un alias AS total para identificar mas facil
    $query = "SELECT COUNT(*) AS total FROM preguntas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function totalPreguntasPorCategoria($tema){
    include("components/conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE id = '$tema'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function obtenerIdsPreguntasPorCategoria($tema){
    include("components/conexion.php");
    $query = "SELECT quizid FROM preguntas WHERE id = '$tema'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function contarPreguntas($tema){
    include("components/conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE id = '$tema'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}