<?php

require('.\fpdf184\fpdf.php');
include 'components/connect.php';


$correctas = $_GET['param1'];
$incorrectas = $_GET['param2'];
$score = $_GET['param4'];
$materia = $_GET['param3'];
$alumno = $_GET['param5'];

class PDF extends FPDF{
    function Header(){
        $this->AddFont('GemunuLibre-ExtraLight','','GemunuLibre-VariableFont_wght.php');
        $this->SetFont('GemunuLibre-ExtraLight','',65);
        $this->Cell(60);
        $this->Cell(70,10,iconv('UTF-8', 'windows-1252', "Reporte ejercicio"),0,0,'C');
        $this->Ln(20);
    }
    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');

    }
};
$pdf = new PDF();
$pdf->AliasNBPages();
$pdf->AddPage();
$pdf->AddFont('GemunuLibre-ExtraLight','','GemunuLibre-VariableFont_wght.php');
$pdf->SetFont('GemunuLibre-ExtraLight','',15);
$pdf->Cell(0,15,iconv('UTF-8', 'windows-1252', 'El sistema de reportes automáticos de CucsurCode para alumnos, reporta que el estudiante:'),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('GemunuLibre-ExtraLight','',50);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252', $alumno),0,0,'C');

$pdf->Ln(20);
$pdf->SetFont('GemunuLibre-ExtraLight','',15);
$pdf->Cell(0,15,iconv('UTF-8', 'windows-1252', 'Obtuvo la siguiente cantidad de respuestas correctas:'),0,0,'C');

$pdf->Ln(20);
$pdf->SetFont('GemunuLibre-ExtraLight','',50);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252', ''.$correctas.'/'.($correctas+$incorrectas)),0,0,'C');

$pdf->Ln(20);
$pdf->SetFont('GemunuLibre-ExtraLight','',15);
$pdf->Cell(0,15,iconv('UTF-8', 'windows-1252', 'En su intento de resolver los ejercicios planteados en la lección: '),0,0,'C');

$pdf->Ln(20);
$pdf->SetFont('GemunuLibre-ExtraLight','',50);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252',$materia ),0,0,'C');

$pdf->Ln(40);
$pdf->SetFont('GemunuLibre-ExtraLight','',25);
$pdf->Cell(130,15,iconv('UTF-8', 'windows-1252', 'Consiguiendo así una puntuación del:'),0,0,'C');
$pdf->SetFont('GemunuLibre-ExtraLight','',80);
$pdf->Cell(50,10,iconv('UTF-8', 'windows-1252',$score.'%' ),0,0,'C');

$pdf->Ln(20);
$pdf->Image('.\images\logoAlumnos.png',10,12,30,0,'','https://i.ytimg.com/vi/E20Qg8LUurA/maxresdefault.jpg');

$pdf->Output();
?>