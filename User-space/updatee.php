<?php
include('connection.php');
?>
<?php
//fonction de validation 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php
if (isset($_POST['admin-update'])) {
    $id_etudiant = $_SESSION['user_id'];
    $getPassres = mysqli_query($connection, "SELECT password FROM etudiant WHERE Apogee = '$id_etudiant';");
    if ($getPassres) {
        $getPass = mysqli_fetch_assoc($getPassres);
        $ancien_psswd = test_input($_POST['ancien_password']);
        $new_password = test_input($_POST['1_new_password']);
        $retype_pass = test_input($_POST['2_new_password']);
        if ($ancien_psswd === $getPass['password']) {
            if ($new_password === $retype_pass) {
                $sql = "UPDATE etudiant SET password= '$new_password' WHERE Apogee = '$id_etudiant';";
                $res = mysqli_query($connection, $sql);
                if ($res) {
                    $_SESSION['pass_succ_status'] = "Votre mot de passe à été bien modifier";

                    header('Location:profile.php?id=1');
                } else {
                    $_SESSION['pass_error_status'] = "Une erreur est survenu lors de la modification du mot de passe";

                    header('Location:profile.php?id=2');
                }
            } else {
                $_SESSION['pass_error_status'] = "Veuillez retapez le mot de passe correctement";

                header('Location:profile.php?id=3');
            }
        } else {
            $_SESSION['pass_error_status'] = "le mot de passe que vous avez saisi ne correspond pas à votre mot de passe courant";
            header('Location:profile.php?id=4');
        }
    }

}


if (isset($_POST['save'])) {
    $name = test_input($_POST['name']);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $prenom = test_input($_POST['prenom']);
    $prenom = filter_var($prenom, FILTER_SANITIZE_STRING);
    $email = test_input($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $cin = test_input($_POST['cin']);
    $phone = test_input($_POST['phone']);
    $id_etudiant = $_SESSION['user_id'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_status'] = "invalide email!";
        header('Location:profile.php?#home');
    } else {
        $result = mysqli_query($connection, "UPDATE etudiant SET nom = '$name', prenom ='$prenom', cin = '$cin' , email='$email', telephone=$phone  WHERE Apogee= $id_etudiant");
        if ($result) {

            $_SESSION['succ_status'] = "Votre profile à été bien modifier";
            header('Location:profile.php?#home');
        } else {
            $_SESSION['error_status'] = "Une erreur est survenu lors de la modification";
            header('Location:profile.php?#home');
        }
    }


}
if (isset($_POST['profil-update-btn'])) {
    header('Location:profile.php?id=#home');
}

?>