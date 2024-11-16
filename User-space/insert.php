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
    if (isset($_POST['text'])) {
        // echo $_POST['text'];
        $attendance_temp_table = mysqli_query($conn, ("CREATE TABLE u_temp_presence(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idEtudiant INTEGER NOT NULL,
            idModule INTEGER NOT NULL,
            statut VARCHAR(30) DEFAULT 'Absent',
            date_presence TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)"));
        if ($attendance_temp_table) {
            $idModule = explode(";", $_POST['text'])[0];
            $apogee = $_SESSION['user_id'];
            $sql = "INSERT INTO u_temp_presence(idEtudiant,idModule,statut,date_presence) VALUES($apogee,$idModule,'Present',NOW())";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['succ'] = "Scanner par succes";
                header("location: scanner.php");
                die();


            } else {
                $_SESSION['error'] = "Erreur lors du scan!!";
                header("location: scanner.php");
                die();
            }
        } else {
            $_SESSION['error'] = "Erreur lors du scan!!";
            header("location: scanner.php");
            die();
        }
        //header("location: index.php");
    }

    mysqli_close($conn);
}
?>