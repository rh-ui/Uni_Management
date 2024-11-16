<?php
function input_test($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
session_start();
$id_prof = $_SESSION['user_id'];
include('connection.php');
if (isset($_POST['u_submit'])) {
    $apogee = (int) trim($_POST['apogee']);
    $cin = filter_var(input_test($_POST['cin']), FILTER_SANITIZE_STRING);
    $name = filter_var(input_test($_POST['name']), FILTER_SANITIZE_STRING);
    $prenom = filter_var(input_test($_POST['prenom']), FILTER_SANITIZE_STRING);
    $email = filter_var(input_test($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phoneNumber = filter_var(input_test($_POST['phoneNumber']), FILTER_VALIDATE_FLOAT);
    $dateNai = input_test($_POST['dateNai']);
    $groupe = filter_var(input_test($_POST['groupe']), FILTER_SANITIZE_STRING);
    $genre = filter_var(input_test($_POST['genre']), FILTER_SANITIZE_STRING);
    //update the user informations on db :
    $sql = "UPDATE etudiant SET nom = '$name', cin='$cin' ,prenom = '$prenom', email='$email', telephone=$phoneNumber,dateDeNaisssance='$dateNai',id_groupe='$groupe' , genre='$genre' WHERE Apogee=$apogee";
    $res = mysqli_query($connection, $sql);
    if ($res) {
        $_SESSION['succ_status'] = $name . " " . $prenom . " a été modifier par succes";
        header('Location:Etudiants.php');
        die();
    } else {
        $_SESSION['error_status'] = "Echec lors de la modification de l'etudiant " . $name . " " . $prenom . " !";
        header('Location:Etudiants.php');
        die();
    }
}

if (isset($_POST['admin-update'])) {
    $getPassres = mysqli_query($connection, "SELECT password FROM professeur WHERE num_serie = '$id_prof';");
    if ($getPassres) {
        $getPass = mysqli_fetch_assoc($getPassres);
        $ancien_psswd = filter_var(input_test($_POST['ancien_password']), FILTER_SANITIZE_STRING);
        $new_password = input_test($_POST['1_new_password']);
        $retype_pass = filter_var(input_test($_POST['2_new_password']), FILTER_SANITIZE_STRING);
        if ($ancien_psswd === $getPass['password']) {
            if ($new_password === $retype_pass) {
                $sql = "UPDATE professeur SET password = '$new_password' WHERE num_serie  = '$id_prof';";
                $res = mysqli_query($connection, $sql);
                if ($res) {
                    $_SESSION['pass_succ_status'] = "Votre mot de passe à été bien modifier";
                    header('Location:settings.php?#profile');
                    die();
                } else {
                    $_SESSION['pass_error_status'] = "Une erreur est survenu lors de la modification du mot de passe";
                    header('Location:settings.php?#profile');
                    die();
                }
            } else {
                $_SESSION['pass_error_status'] = "Veuillez retapez le mot de passe correctement";
                header('Location:settings.php?#profile');
                die();
            }
        } else {
            $_SESSION['pass_error_status'] = "le mot de passe que vous avez saisi ne correspond pas à votre mot de passe courant";
            header('Location:settings.php?#profile');
            die();
        }
    }

}


if (isset($_POST['save'])) {
    $name = filter_var(input_test($_POST['name']), FILTER_SANITIZE_STRING);
    $prenom = filter_var(input_test($_POST['prenom']), FILTER_SANITIZE_STRING);
    $email = filter_var(input_test($_POST['email']), FILTER_VALIDATE_EMAIL);
    $cin = filter_var(input_test($_POST['cin']), FILTER_SANITIZE_STRING);
    $phone = filter_var(input_test($_POST['phone']), FILTER_VALIDATE_FLOAT);
    $result = mysqli_query($connection, "UPDATE professeur SET nom = '$name', prenom ='$prenom',cin = '$cin' ,email='$email', telephone=$phone WHERE num_serie  = '$id_prof';");
    if ($result) {
        $_SESSION['succ_status'] = "Votre profile à été bien modifier";
        header('Location:settings.php?#home');
        die();
    } else {
        $_SESSION['error_status'] = "Une erreur est survenu lors de la modification";
        header('Location:settings.php?#home');
        die();
    }
}
if (isset($_POST['profil-update-btn'])) {
    header('Location:settings.php?#home');
    die();
}


if (isset($_GET['id_file'])) {
    $variable = $_GET['id_file'];
    $filename = $_FILES['fil']['name'];
    $destination = "uploads/" . $filename;
    $extensio = pathinfo($filename, PATHINFO_EXTENSION);
    $fil = $_FILES['fil']['tmp_name'];
    $size = $_FILES['fil']['size'];
    if (file_exists($destination)) {
        $_SESSION['error_upload'] = "Ce nom du fichier existe déjà !";
        header('Location:uploadFile.php');
        die();
    }
    if (!in_array($extensio, ['zip', 'pdf', 'png', 'jpg', 'jpeg'])) {
        $_SESSION['error_upload'] = "Veuillez entrez un fichire d'extension : 'zip', 'pdf', 'png', 'jpg', ou 'jpeg'";
        header('Location:uploadFile.php');
        die();
    } elseif ($_FILES['fil']['size'] > 5000000) { //>5MO
        $_SESSION['error_upload'] = "La taille du fichier dépasse 5 MO !!";
        header('Location:uploadFile.php');
        die();
    } elseif (move_uploaded_file($fil, $destination)) {
        $date = date("Y-m-d");
        $st = "UPDATE files set destination='$destination',extention='$extensio',date_p='$date' where id=$variable ";
        $re = mysqli_query($connection, $st);
        if ($re) {
            $_SESSION['succ_upload'] = "votre fichier à été bien télécharger";
            header('Location:uploadFile.php');
        } else {
            $_SESSION['error_upload'] = "Erreur lors du téléchargement";
            header('Location:uploadFile.php');
        }
    } else {
        $_SESSION['error_upload'] = "Erreur lors du téléchargement";
        header('Location:uploadFile.php');
    }
}
?>