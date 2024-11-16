<?php
session_start();
$prof_id = $_SESSION['user_id'];
$id_Module = $_GET['id'];
include("fpdf185/fpdf.php");
include('connection.php');
$pdf = new FPDF();
$pdf->SetTopMargin(30);
$pdf->AddPage();
$pdf->Image('imgs/fso.jpeg',17,10, 30, 30);
$pdf->Image('imgs/fso.jpeg',170,10, 30, 30);
$pdf->SetFont("Arial", "B", 16);
$pdf->SetTextColor(252, 3, 3);
$pdf->Cell(200, 20, "Liste des etudiants", "0", "1","C");
$res =mysqli_fetch_assoc(mysqli_query($connection,"SELECT nomModule FROM module WHERE id_module='$id_Module' AND idProfesseur = '$prof_id'"));
$pdf->Cell(200, 20,mb_convert_encoding($res['nomModule'], 'ISO-8859-1', 'UTF-8'), "0", "1","C");
$pdf->SetMargins(30, 70, 30);
//table column :
$pdf->SetLeftMargin(30);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(40, 10, "Apogee", "1", "0", "C"); //cellule lwla        |
//         ^-->width dyal la cellule                               |
$pdf->Cell(40, 10, "Nom", "1", "0", "C"); //cellule zwja           |------->Ligne 
$pdf->Cell(40, 10, "Prenom", "1", "0", "C"); //cellule talta       | 
$pdf->Cell(40, 10, "Groupe", "1", "1", "C"); //cellule talta       |
$pdf->SetFont("Arial", "", 14);
$res = mysqli_query($connection, "SELECT * FROM etudie,etudiant,module WHERE module.id_module='$id_Module' AND module.idProfesseur = '$prof_id' AND module.id_module = etudie.idModule AND etudiant.Apogee = etudie.idEtudiant;");
while ($row = mysqli_fetch_assoc($res)) {
    $pdf->Cell(40, 10, $row['Apogee'], "1", "0", "C"); //cellule lwla                       |
    //             ^-->height dyal la cellule                                               |
    $pdf->Cell(40, 10, $row['nom'], "1", "0", "C"); //cellule zwja                          |------->Ligne 
    $pdf->Cell(40, 10, $row['prenom'], "1", "0", "C"); //cellule talta                      | 
    $pdf->Cell(40, 10, $row['id_groupe'], "1", "1", "C"); # akhir whda kandirou fiha 1,1    |
}
$pdf->Output();
?>