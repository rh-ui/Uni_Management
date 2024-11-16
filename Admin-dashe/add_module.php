<?php 
function input_test($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlentities($data);
    return $data;
}
session_start();
$prof_id = $_SESSION['user_id'];
include('connection.php');
if(isset($_POST['add_mod'])){
    $id_fil = $_POST['filiere'];
    $semester = $_POST['semester'];
    $nom = input_test(filter_var($_POST['nom'],FILTER_SANITIZE_STRING));
    $id  = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM module order by id_module DESC LIMIT 1"));
    $id = $id['id_module']+1;
    echo $id_fil.$semester.$id.$nom;
    $res = mysqli_query($connection,"INSERT INTO module (id_module,nomModule,idProfesseur) VALUES ('$id','$nom','$prof_id')");
    $res2 = mysqli_query($connection,"INSERT INTO module_filiere (idModule,idFiliere,semester) VALUES ('$id','$id_fil','$semester')");
    if ($res && $res2){
        $_SESSION['succ_status'] = "Module ajouter par succes";
        header('Location:index.php');
        die();
    }
    else{
        $_SESSION['error_status'] = "Erreur lors d'ajout!!";
        header('Location:index.php');
        die();
    }
}
?>