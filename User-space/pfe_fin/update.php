<?php
include('connection.php');

$apogee = (int) trim($_POST['apogee']);
$name = $_POST['name'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$phoneNumber = (int) trim($_POST['phoneNumber']);
$dateNai = $_POST['dateNai'];
//update the user informations on db :
$sql = "UPDATE etudiant SET nom = '$name' ,prenom = '$prenom', email='$email', telephone=$phoneNumber,dateDeNaisssance='$dateNai' WHERE Apogee=$apogee";
$res = mysqli_query($connection, $sql);
if ($res) {
    header('Location:Etudiants.php');
}


?>