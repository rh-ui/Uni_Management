<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "project";
$connection = mysqli_connect("$server", "$username", "$password");
$select_db = mysqli_select_db($connection, $database);
if (!$select_db) {
    echo ("connection terminated");
}


if(isset($_POST['save'])){
    $filename = $_FILES['myfile']['name'];
    $destination = 'uploads/'.$filename;
    $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    if(!in_array($extension,['zip','pdf','png','jpg'])){
        echo "your file extension must be : .zip .pdf .jpg or .png ";
    }
    elseif($_FILES['myfile']['size'] > 1000000){ //>1MO
        echo "file is to large";
    }
    else{
        if(move_uploaded_file($file,$destination)){
            $sql = "INSERT INTO files (name,size) VALUES ('$filename','$size');";
            $res = mysqli_query($connection,$sql);
            if($res){
                echo "file uploaded successflly";
            }
            else{
                echo "failed to load file";
            }
        }
    }
}

if(isset($_GET['id_file'])){
    $id = $_GET['id_file'];
    $file = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM files WHERE file_id =$id;"));
    $filepath = 'uploads/'.$file['name'];
    if(file_exists($filepath)){
        header('Content-Type: application/octet/stream');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename = '. basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-length:'.filesize('uploads/'.$file['name']));

        readfile('uploads/'.$file['name']);
        
        exit;
    }
}
?>