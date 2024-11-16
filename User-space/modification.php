<?php
// connect to database
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'project';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die('error' . mysqli_error($conn));
} else {
    //$sql = "SELECT * FROM files";
    //$result = mysqli_query($conn, $sql);

    //$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Downloads files
    if (isset($_GET['id_file'])) {
        $id = $_GET['id_file'];
        // fetch file to download from database
        session_start();
        $id_et = $_SESSION['user_id'];


        $file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM files where id=$id"));
        $download = $file['downloads'] + 1;
        $fileExtension = $file['extention'];
        // Set content type based on file extension
        $filepath = '../Admin-dashe/' . $file['destination'];

        if (file_exists($filepath)) {
            $file = mysqli_query($conn, "UPDATE files SET downloads=$download where id=$id");
            header('Content-Type: application/pdf');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename = ' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-length:' . filesize($filepath));

            ob_clean();
            flush();
            $fileStream = fopen($filepath, 'r+');
            fpassthru($fileStream);
            $currentContent = file_get_contents($filepath);
            $newContent = str_replace('ancien texte', 'nouveau texte', $currentContent);
            // Réécrire le contenu modifié dans le fichier
            file_put_contents($filepath, $newContent);
            fclose($fileStream);
            exit;
        }

    }
}

?>