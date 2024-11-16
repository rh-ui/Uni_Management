<?php
session_start();
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'project';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die('error' . mysqli_error($conn));

} else {
    // récupérer les données du formulaire par la methode post 
    if (isset($_POST['your_name']) && isset($_POST['your_name'])) {

        $username = mysqli_real_escape_string($conn, $_POST['your_name']);
        $password = mysqli_real_escape_string($conn, $_POST['your_pass']);

        // récupérer les informations d'identification de l'utilisateur depuis la base de données
        $sql = "SELECT * FROM etudiant WHERE apogee= '$username'AND mot_passe='$password'";
        $result = mysqli_query($conn, $sql);
        // vérifier si les informations d'identification sont valides
        if (mysqli_num_rows($result) == 1) {
            // stocker l'identifiant de l'utilisateur dans la session
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['apogee'];
            header('Location: ../index.php'); // rediriger vers la page de tableau de bord
//maintenant if faut mettre les ids qui scan en code qr

            exit;
        } else {
            // afficher un message d'erreur
            $error_message = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }

}






?>