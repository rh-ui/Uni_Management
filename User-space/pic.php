<?php
if (isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])) {
    $id_etudiant = $_SESSION['user_id'];
    $filename = $_FILES['file']['name'];
    $destination = 'profile/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    if (file_exists($destination)) {
        $sql = "UPDATE etudiant set profile='$destination' where Apogee=$id_etudiant ";
        $result = mysqli_query($connection, $sql);



    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE etudiant set profile='$filename' where Apogee=$id_etudiant ";
            $result = mysqli_query($connection, $sql);


        }

    }
}


?>