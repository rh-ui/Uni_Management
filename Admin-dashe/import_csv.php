<?php
// Connect to database
session_start();
include("connection.php");
if (isset($_POST["import"])) {
    $id_module = $_POST["import"];
    $fileName = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
            $apogee = $column[0];
            $cin = $column[1];
            $password = $column[1];
            $name = $column[2];
            $prenom = $column[3];
            $email = $column[4];
            $phoneNumber = $column[5];
            $dateNai = $column[6];
            $groupe = $column[7];
            $genre = $column[8];
            $sql = "SELECT * FROM etudiant WHERE Apogee = '$apogee';";
            $res = mysqli_query($connection, $sql);
            if (mysqli_num_rows($res) == 0) {
                $getCin = mysqli_query($connection, "SELECT cin FROM etudiant;");
                if ($getCin) {
                    $getCin = mysqli_fetch_assoc($getCin);
                    if ($getCin['cin'] == $cin) {
                        $_SESSION['error_status'] = "Ce numero de cin existe déjà!";
                        header('Location:Etudiants.php');
                    } else {
                        $result_1 = mysqli_query($connection, "INSERT INTO etudiant (Apogee,cin,nom,prenom,email,telephone,dateDeNaisssance,id_groupe,password,genre) VALUES ('$apogee','$cin','$name','$prenom','$email','$phoneNumber','$dateNai','$groupe','$cin','$genre');");
                        $result_2 = mysqli_query($connection, "INSERT INTO etudie VALUES ($apogee,$id_module);");
                        if ($result_1 && $result_2) {
                            $_SESSION['succ_status'] = "succes d\'importation";
                            header('Location:Etudiants.php');
                        } else {
                            $_SESSION['error_status'] = "Echec lors de l\'importation";
                            header('Location:Etudiants.php');
                        }
                    }
                }
            } else {
                $sql_res = mysqli_query($connection, "SELECT * FROM etudie WHERE idModule='$id_module' AND idEtudiant = '$apogee';");
                if (mysqli_num_rows($sql_res) == 0) {
                    $result_3 = mysqli_query($connection, "INSERT INTO etudie VALUES ($apogee,$id_module);");
                    if ($result_3) {
                        $_SESSION['succ_status'] = "succes d\'importation";
                        header('Location:Etudiants.php');
                    } else {
                        $_SESSION['error_status'] = "Echec lors de l\'importation";
                        header('Location:Etudiants.php');
                        die();
                    }
                } else {
                    $_SESSION['error_status'] = "Cet etudiant existe déjà";
                    header('Location:Etudiants.php');
                    die();
                }
            }
        }
    } else {
        $_SESSION['error_status'] = "Echec lors de l\'importation";
        header('Location:Etudiants.php');
        die();
    }
}
?>