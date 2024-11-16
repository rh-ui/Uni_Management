<?php
if (isset($_GET['import_example'])) {
    $fileExtension = $file['extention'];
    // Set content type based on file extension
    $filepath = "uploads/test.csv";
    if (file_exists($filepath)) {
        header('Content-Type: application/octet/stream');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename = ' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-length:' . filesize($filepath));
        ob_clean();
        flush();
        $fileStream = fopen($filepath, 'r');
        fpassthru($fileStream);
        fclose($fileStream);
        exit;
    }
}
?>