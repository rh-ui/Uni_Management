<?php
function input_test($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
session_start();
include('connection.php');
if (isset($_POST['add-user'])) {
  $apogee = filter_var(input_test($_POST['apogee']),FILTER_VALIDATE_FLOAT);
  $cin = filter_var(input_test($_POST['cin']),FILTER_SANITIZE_STRING);
  $name = filter_var(input_test($_POST['name']),FILTER_SANITIZE_STRING);
  $prenom = filter_var(input_test($_POST['prenom']),FILTER_SANITIZE_STRING);
  $email = filter_var(input_test($_POST['email']),FILTER_VALIDATE_EMAIL);
  $phoneNumber = filter_var(input_test($_POST['phoneNumber']),FILTER_VALIDATE_FLOAT);
  $dateNai = input_test($_POST['dateNai']);
  $groupe = filter_var(input_test($_POST['groupe']),FILTER_SANITIZE_STRING);
  $genre = filter_var(input_test($_POST['genre']),FILTER_SANITIZE_STRING);
  $module = filter_var(input_test($_POST['module']),FILTER_SANITIZE_STRING);
  $getIdModule = mysqli_query($connection, "SELECT id_module FROM module WHERE nomModule = '$module';");
  if(($getIdModule)){
    $getIdModule = mysqli_fetch_assoc($getIdModule);
    $id_module = $getIdModule['id_module'];
  }
  $sql = "SELECT * FROM etudiant WHERE Apogee = '$apogee';";
  $res = mysqli_query($connection, $sql);
  if (mysqli_num_rows($res) == 0) { // User does not exist, insert user data into database
    $getCin = mysqli_fetch_assoc(mysqli_query($connection, "SELECT cin FROM etudiant;"));
    if ($getCin['cin'] == $cin) {
      $_SESSION['error_status'] = "double CIN";
      header('Location:Etudiants.php');
      die();
    } else {
      $result_1 = mysqli_query($connection, "INSERT INTO etudiant (Apogee,cin,nom,prenom,email,telephone,dateDeNaisssance,id_groupe,genre,password) VALUES ('$apogee','$cin','$name','$prenom','$email','$phoneNumber','$dateNai','$groupe','$genre','$cin');");
      $result_2 = mysqli_query($connection, "INSERT INTO etudie VALUES ($apogee,$id_module);");
      if ($result_1 && $result_2) {
        $_SESSION['succ_status']=  $name." ".$prenom." à été bien ajouter";;
        header('Location:Etudiants.php');
        die();
      } else {
        $_SESSION['error_status'] = "Echec d'ajout";
        header('Location:Etudiants.php');
        die();
      }
    }
  } else {
    $sql_res = mysqli_query($connection, "SELECT * FROM etudie WHERE idModule='$id_module' AND idEtudiant = '$apogee';");
    if (mysqli_num_rows($sql_res) == 0) {
      $result_3 = mysqli_query($connection, "INSERT INTO etudie VALUES ($apogee,$id_module);");
      if ($result_3) {
        $_SESSION['succ_status']= $name." ".$prenom." à été bien ajouter";
        header('Location:Etudiants.php');
        die();
      }
    } else {
      $_SESSION['error_status'] = $name." ".$prenom." existe déja";
      header('Location:Etudiants.php');
      die();
    }
  }
}
?>


