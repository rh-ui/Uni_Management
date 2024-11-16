<?php
require('connection.php');
session_start();
if (isset($_POST['delete'])) {
    $apogee = $_POST['delete'];
    $etudiant =mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM etudiant WHERE Apogee= '$apogee';"));
    $res = mysqli_query($connection, "SELECT idModule FROM etudie WHERE idEtudiant= '$apogee';");
    if ($res) {
        $idModule = mysqli_fetch_assoc($res);
        $idModule = $idModule['idModule'];
        $result = mysqli_query($connection, "DELETE FROM etudie WHERE idModule = '$idModule' AND idEtudiant = '$apogee'");
        if ($result) {
            $_SESSION['succ_status'] = $etudiant['nom']." ".$etudiant['prenom']." a été bien supprimer";
            header('Location:Etudiants.php');
            die();
        }
        else{
            $_SESSION['error_status'] = "Echec lors de la suppression de l'etudiant ". $etudiant['nom']." ".$etudiant['prenom']." !";
            header('Location:Etudiants.php');
            die();
        }
    }
}
if (isset($_POST['file_delete'])) {
    $id = $_POST['file_delete'];
    $result = mysqli_query($connection, "DELETE FROM files WHERE id = '$id';");
    if ($result) {
        $_SESSION['succ_upload'] = "Votre fichier à été bien supprimer";
        header('Location:uploadFile.php');
        die();
    }else{
        $_SESSION['error_upload'] = "Erreur lors de la suppression";
        header('Location:uploadFile.php');
        die();
    }
}
?>