<?php
function input_test($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
session_start();
include('connection.php');
?>

<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>


<?php

// récupérer les données du formulaire par la methode post 
if (isset($_POST['numSerie']) && isset($_POST['CIN'])) {
    $login = filter_var(input_test($_POST['numSerie']),FILTER_SANITIZE_STRING);
    $username = mysqli_real_escape_string($connection, $login);
    $psswd = filter_var(input_test($_POST['CIN']),FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($connection, $psswd);

    // récupérer les informations d'identification de l'utilisateur depuis la base de données
    $sql = "SELECT * FROM professeur WHERE num_serie  = '$username' AND password ='$password'";
    $result = mysqli_query($connection, $sql);
    // vérifier si les informations d'identification sont valides
    if (mysqli_num_rows($result) == 1) {
        // stocker l'identifiant de l'utilisateur dans la session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['num_serie'];
        // $_SESSION['success_msg'] = "Bienvenu ".$row['nom']." ".$row['prenom'];
        header('Location: ../Admin-dashe/index.php');
        exit;
    } else {
        $_SESSION['error_status'] = 'Nom d\'utilisateur ou mot de passe incorrect';
        header('Location:adminLogin.php');
    }
}
if (isset($_POST['Apogee']) && isset($_POST['CIN'])) {

    $login = filter_var(input_test($_POST['Apogee']),FILTER_VALIDATE_FLOAT) ;
    $username = mysqli_real_escape_string($connection, $login);
    // $username = mysqli_real_escape_string($connection, $_POST['Apogee']);
    $psswd = filter_var(input_test($_POST['CIN']),FILTER_SANITIZE_STRING) ;
    $password = mysqli_real_escape_string($connection,$psswd);

    // récupérer les informations d'identification de l'utilisateur depuis la base de données
    $sql = "SELECT * FROM etudiant WHERE Apogee = '$username'AND password='$password'";
    $result = mysqli_query($connection, $sql);
    // vérifier si les informations d'identification sont valides
    if (mysqli_num_rows($result) == 1) {
        // stocker l'identifiant de l'utilisateur dans la session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['Apogee'];
        // $_SESSION['u_success_msg'] = "Bienvenu ".$row['nom']." ".$row['prenom'];
        header('Location: ../User-space/index.php');
        // rediriger vers la page de tableau de bord
        exit;
    } else {
        $_SESSION['error_status'] = 'Nom d\'utilisateur ou mot de passe incorrect';
        header('Location:userLogin.php');
    }
}
?>

</html>