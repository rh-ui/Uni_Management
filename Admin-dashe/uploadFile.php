<?php
session_start();
$prof_id = $_SESSION['user_id'];
$id_Module = $_SESSION['id_module'];
include('connection.php');

if (isset($_POST['submit'])) {
    $filename = $_FILES['myfile']['name'];
    $destination = 'uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    $fileType = $_POST['file_type'];
    if (!in_array($extension, ['zip', 'pdf', 'png', 'jpg', 'jpeg'])) {
        $_SESSION['error_upload'] = "Veuillez entrez un fichire d'extension : 'zip', 'pdf', 'png', 'jpg', ou 'jpeg'";
        header('Location:uploadFile.php');
        die();
    } elseif ($_FILES['myfile']['size'] > 5000000) { //>5MO
        $_SESSION['error_upload'] = "La taille du fichier dépasse 5 MO !!";
        header('Location:uploadFile.php');
        die();
    } else {
        $id = mysqli_query($connection, "SELECT * FROM files WHERE name ='$filename';");
        if (mysqli_num_rows($id) == 0) {
            if (move_uploaded_file($file, $destination)) {
                $res = mysqli_query($connection, "INSERT INTO files (name,size,downloads,idModule,destination,extention,categorie) VALUES ('$filename','$size',0,'$id_Module','$destination','$extension','$fileType');");
                if ($res) {
                    $_SESSION['succ_upload'] = "votre fichier à été bien télécharger";
                    header('Location:uploadFile.php');
                    die();
                } else {
                    $_SESSION['error_upload'] = "Erreur lors du téléchargement";
                    header('Location:uploadFile.php');
                    die();
                }
            }

        } else {
            $_SESSION['error_upload'] = "Ce nom du fichier existe déjà !";
            header('Location:uploadFile.php');
            die();
        }
    }
}

if (isset($_POST['file_state'])) {
    // Récupération des valeurs soumises par le formulaire
    $fileId = $_POST['file_state'];
    $newState = mysqli_query($connection, "SELECT * FROM files WHERE id='$fileId';");
    if ($newState) {
        $newState = mysqli_fetch_assoc($newState);
        $newState = $newState['file_etat'];
        if ($newState == "visible") {
            $file_res = mysqli_query($connection, "UPDATE files SET file_etat='cache' WHERE id='$fileId';");
            if ($file_res) {
                $_SESSION['succ_upload'] = "Votre fichier est cache";
                header('Location:uploadFile.php');
                die();
            } else {
                $_SESSION['error_upload'] = "Echec ! Veuillez réessayer plus tard";
                header('Location:uploadFile.php');
                die();
            }
        } else {
            $file_res = mysqli_query($connection, "UPDATE files SET file_etat='visible' WHERE id='$fileId';");
            if ($file_res) {
                $_SESSION['succ_upload'] = "Votre fichier est visible";
                header('Location:uploadFile.php');
                die();
            } else {
                $_SESSION['error_upload'] = "Echec ! Veuillez réessayer plus tard";
                header('Location:uploadFile.php');
                die();
            }
        }
    }

}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../login/adminLogin.php');
    die();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/framework.css" />
    <link rel="stylesheet" href="css/master.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto|Varela+Round'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href='css/bootstrap/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel='stylesheet' href='css/bootstrap/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .file {
      position: relative;
      overflow: hidden;
    }

    .myfile {
      position: absolute;
      font-size: 50px;
      opacity: 0;
      right: 0;
      top: 0;
    }
  </style>
</head>

<body>
    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">

            <!-- Start Head -->
            <?php include('header.php'); ?>
            <!-- End Head -->
            <!--Students table-->
            <div>
                <h1 class="p-relative">Inserertion des fichiers :
                    <!-- <a href="addUser.php" id="btn"><i class='bx bx-plus bx-rotate-90'></i></a> -->
                </h1>
            </div>
            <div class="projects p-20 bg-white rad-10 m-20">
                <?php
                if (isset($_SESSION['succ_upload']) && $_SESSION['succ_upload'] != "") {
                    ?>
                                                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                                                <?php echo $_SESSION['succ_upload']; ?>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                            </div>
                                                                            <?php
                                                                            unset($_SESSION['succ_upload']);
                }
                if (isset($_SESSION['error_upload']) && $_SESSION['error_upload'] != "") {
                    ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <?php echo $_SESSION['error_upload'];
                                                                                unset($_SESSION['error_upload']); ?>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                            </div>
                                                                            <?php

                }
                ?>
                <div>
                    <!-- <h2 class="w-fs mt-0 mb-20">Posez votre fichier à télécharger ici :</h2> -->
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method='post' enctype="multipart/form-data">
                        <label for="files" class="drop-container row">
                            <span class="drop-title">Télécharger ici</span>
                            <br>
                            <div class="input-group d-flex justify-content-center">
                                <input type="file" name="myfile" required>
                                <select name="file_type" class="form-select border-dark border-start-0 col-md-1"
                                    required>
                                    <option value="cours">Cours</option>
                                    <option value="td">TD</option>
                                    <option value="tp">TP</option>
                                </select>
                            </div>
                            <button type="submit" class='btn' name="submit">télécharger</button>
                        </label>
                    </form>
                </div>
                <h2 class="w-fs mt-0 mb-20">Vos fichiers :</h2>
                <!-- Start Cours table -->
                <div class="responsive-table table">
                    <table class="w-full text-center mb-3">
                        <thead>
                            <tr>
                                <td>Cours</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='align-middle'>
                                    <div class="responsive-table">
                                        <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <td>fichier</td>
                                                    <td>size</td>
                                                    <td>Nombre de téléchargement</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $get_cours = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id_Module' AND categorie = 'cours'");
                                                if ($get_cours) {
                                                    while ($cours = mysqli_fetch_assoc($get_cours)) {
                                                        ?>
                                                                                                                                                                        <tr>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php
                                                                                                                                                                                $extension = pathinfo($cours['name'], PATHINFO_EXTENSION);
                                                                                                                                                                                if (in_array($extension, ['zip'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                            <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                <div class='txt-c between-block'>
                                                                                                                                                                                                                                                    <img class='mt-15 mb-15 item-c' src='imgs/zip.svg'>
                                                                                                                                                                                                                                                    <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                        <?php echo $cours['name'] ?>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                            <?php
                                                                                                                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                    <div class='txt-c between-block'>
                                                                                                                                                                                                                                                        <img class='mt-15 mb-15 item-c' src='imgs/pdf.svg'>
                                                                                                                                                                                                                                                        <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                            <?php echo $cours['name'] ?>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                <?php
                                                                                                                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                    <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                        <div class='txt-c between-block'>
                                                                                                                                                                                                                                                            <img class='mt-15 mb-15 item-c' src='imgs/png.svg'>
                                                                                                                                                                                                                                                            <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                                <?php echo $cours['name'] ?>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                    <?php
                                                                                                                                                                                }
                                                                                                                                                                                ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $cours['size'] / 1000 . " Kbs"; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $cours['downloads']; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class="align-middle">
                                                                                                                                                                                <!-- Start Visibility -->
                                                                                                                                                                                <div class="d-inline">
                                                                                                                                                                                    <form class="d-inline" action="update.php?id_file=<?php echo $cours['id'];?>" method="POST" id="form-cours"
                                                                                                                                                                                        enctype="multipart/form-data" class="file-form">
                                                                                                                                                                                        <div class="file btn btn btn-outline-dark">
                                                                                                                                                                                        <i class='bx bxs-edit-alt'>
                                                                                                                                                                                            <input type="file" name="fil" class="myfile" id="fil" />
                                                                                                                                                                                        </i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <form class="d-inline" id="fileForm_<?php echo $cours['id']; ?>"
                                                                                                                                                                                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                                                                                                                                                        <button type="submit" name="file_state" class="eye-button btn btn-outline-dark" value="<?php echo $cours['id']; ?>">
                                                                                                                                                                                            <i class="fas fa-eye <?php if ($cours['file_etat'] == 'cache')
                                                                                                                                                                                                echo 'd-none'; ?>"
                                                                                                                                                                                            value="<?php echo $cours['file_etat']; ?>" id="show_eye_<?php echo $cours['id']; ?>"></i>
                                                                                                                                                                                            <i class="fas fa-eye-slash <?php if ($cours['file_etat'] == 'visible')
                                                                                                                                                                                                echo 'd-none'; ?>"
                                                                                                                                                                                            value="<?php echo $cours['file_etat']; ?>" id="hide_eye_<?php echo $cours['id']; ?>"></i>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <!-- End Visibility -->
                                                                                                                                                                                    <!-- Start Suppression -->
                                                                                                                                                                                    <button type='button' class='btn btn-info alertbox'
                                                                                                                                                                                        data-id='<?php echo $cours['id']; ?>' data-toggle="modal">
                                                                                                                                                                                        <i class='bx bx-trash'></i>
                                                                                                                                                                                    </button>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class="modal fade" id="myModal-<?php echo $cours['id']; ?>"
                                                                                                                                                                                    tabindex="-1" role="dialog">
                                                                                                                                                                                    <div class='modal-dialog' role='document'>
                                                                                                                                                                                        <div class='modal-content'>
                                                                                                                                                                                            <div class='modal-header'>
                                                                                                                                                                                                <h5 class='modal-title'>Confirmation de la
                                                                                                                                                                                                    supression</h5>
                                                                                                                                                                                                <button type="button" class="close"
                                                                                                                                                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                                                                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                                                                                                                </button>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-body'>
                                                                                                                                                                                                <p id='error-"<?php echo $cours['id']; ?>'></p>
                                                                                                                                                                                                <div class='alert alert-danger' role='alert'>
                                                                                                                                                                                                    voulez vous vraiment supprimer le fichier
                                                                                                                                                                                                    :<br>
                                                                                                                                                                                                    <?php echo $cours['name']; ?>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-footer'>
                                                                                                                                                                                                <form action='delete.php' method='post'>
                                                                                                                                                                                                    <button type='submit' name='file_delete'
                                                                                                                                                                                                        class='btn btn-primary'
                                                                                                                                                                                                        value='<?php echo $cours['id']; ?>'>
                                                                                                                                                                                                        Supprimer
                                                                                                                                                                                                    </button>
                                                                                                                                                                                                    <button type='button'
                                                                                                                                                                                                        class='btn btn-secondary'
                                                                                                                                                                                                        data-bs-dismiss='modal'>ignorer</button>
                                                                                                                                                                                                </form>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End cours table -->
                <!-- Start Tp table -->
                <div class="responsive-table table">
                    <table class="w-full text-center mb-3">
                        <thead>
                            <tr>
                                <td>Travaux Pratiques</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='align-middle'>
                                    <div class="responsive-table">
                                        <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <td>fichier</td>
                                                    <td>size</td>
                                                    <td>Nombre de téléchargement</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $get_tp = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id_Module' AND categorie = 'tp'");
                                                if ($get_tp) {
                                                    while ($tp = mysqli_fetch_assoc($get_tp)) {
                                                        ?>
                                                                                                                                                                        <tr>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php
                                                                                                                                                                                $extension = pathinfo($tp['name'], PATHINFO_EXTENSION);
                                                                                                                                                                                if (in_array($extension, ['zip'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                            <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                <div class='txt-c between-block'>
                                                                                                                                                                                                                                                    <img class='mt-15 mb-15 item-c' src='imgs/zip.svg'>
                                                                                                                                                                                                                                                    <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                        <?php echo $tp['name'] ?>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                            <?php
                                                                                                                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                    <div class='txt-c between-block'>
                                                                                                                                                                                                                                                        <img class='mt-15 mb-15 item-c' src='imgs/pdf.svg'>
                                                                                                                                                                                                                                                        <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                            <?php echo $tp['name'] ?>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                <?php
                                                                                                                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                    <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                        <div class='txt-c between-block'>
                                                                                                                                                                                                                                                            <img class='mt-15 mb-15 item-c' src='imgs/png.svg'>
                                                                                                                                                                                                                                                            <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                                <?php echo $tp['name'] ?>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                    <?php
                                                                                                                                                                                }
                                                                                                                                                                                ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $tp['size'] / 1000 . " Kbs"; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $tp['downloads']; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class="align-middle">
                                                                                                                                                                                <!-- Start Visibility -->
                                                                                                                                                                                <div class="d-inline">
                                                                                                                                                                                    <form class="d-inline" action="update.php?id_file=<?php echo $tp['id'];?>" method="POST" id="form-tp"
                                                                                                                                                                                        enctype="multipart/form-data" class="file-form">
                                                                                                                                                                                        <div class="file btn btn btn-outline-dark">
                                                                                                                                                                                        <i class='bx bxs-edit-alt'>
                                                                                                                                                                                            <input type="file" name="fil" class="myfile" id="fil" />
                                                                                                                                                                                        </i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <form class="d-inline" id="fileForm_<?php echo $tp['id']; ?>"
                                                                                                                                                                                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                                                                                                                                                        <button type="submit" name="file_state" class="eye-button btn btn-outline-dark" value="<?php echo $tp['id']; ?>">
                                                                                                                                                                                            <i class="fas fa-eye <?php if ($tp['file_etat'] == 'cache')
                                                                                                                                                                                                echo 'd-none'; ?>"
                                                                                                                                                                                            value="<?php echo $tp['file_etat']; ?>" id="show_eye_<?php echo $tp['id']; ?>"></i>
                                                                                                                                                                                            <i class="fas fa-eye-slash <?php if ($tp['file_etat'] == 'visible')
                                                                                                                                                                                                echo 'd-none'; ?>"
                                                                                                                                                                                            value="<?php echo $tp['file_etat']; ?>" id="hide_eye_<?php echo $tp['id']; ?>"></i>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <!-- End Visibility -->
                                                                                                                                                                                    <!-- Start Suppression -->
                                                                                                                                                                                    <button type='button' class='btn btn-info alertbox'
                                                                                                                                                                                        data-id='<?php echo $tp['id']; ?>'><i
                                                                                                                                                                                            class='bx bx-trash'></i>
                                                                                                                                                                                    </button>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class='modal fade' id='myModal-<?php echo $tp['id']; ?>'
                                                                                                                                                                                    tabindex='-1' role='dialog'>
                                                                                                                                                                                    <div class='modal-dialog' role='document'>
                                                                                                                                                                                        <div class='modal-content'>
                                                                                                                                                                                            <div class='modal-header'>
                                                                                                                                                                                                <h5 class='modal-title'>Confirmation de la
                                                                                                                                                                                                    supression</h5>
                                                                                                                                                                                                <button type='button' class='close'
                                                                                                                                                                                                    data-bs-dismiss='modal' aria-label='Close'>
                                                                                                                                                                                                    <span aria-hidden='true'>&times;</span>
                                                                                                                                                                                                </button>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-body'>
                                                                                                                                                                                                <p id='error-"<?php echo $tp['id']; ?>'></p>
                                                                                                                                                                                                <div class='alert alert-danger' role='alert'>
                                                                                                                                                                                                    voulez vous vraiment supprimer le fichier
                                                                                                                                                                                                    :<br>
                                                                                                                                                                                                    <?php echo $tp['name']; ?>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-footer'>
                                                                                                                                                                                                <form action='delete.php' method='post'>
                                                                                                                                                                                                    <button type='submit' name='file_delete'
                                                                                                                                                                                                        class='btn btn-primary'
                                                                                                                                                                                                        value='<?php echo $tp['id']; ?>'>
                                                                                                                                                                                                        Supprimer
                                                                                                                                                                                                    </button>
                                                                                                                                                                                                    <button type='button'
                                                                                                                                                                                                        class='btn btn-secondary'
                                                                                                                                                                                                        data-bs-dismiss='modal-<?php echo $tp['id']; ?>'>ignorer</button>
                                                                                                                                                                                                </form>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <!-- End Suppression -->
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End Tp table -->
                <!-- Start Td table -->
                <div class="responsive-table table">
                    <table class="w-full text-center mb-3">
                        <thead>
                            <tr>
                                <td>Travaux Dirigés</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='align-middle'>
                                    <div class="responsive-table">
                                        <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <td>fichier</td>
                                                    <td>size</td>
                                                    <td>Nombre de téléchargement</td>
                                                    <td>Actions</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $get_td = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id_Module' AND categorie = 'td'");
                                                if ($get_tp) {
                                                    while ($td = mysqli_fetch_assoc($get_td)) {
                                                        ?>
                                                                                                                                                                        <tr>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php
                                                                                                                                                                                $extension = pathinfo($td['name'], PATHINFO_EXTENSION);
                                                                                                                                                                                if (in_array($extension, ['zip'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                            <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                <div class='txt-c between-block'>
                                                                                                                                                                                                                                                    <img class='mt-15 mb-15 item-c' src='imgs/zip.svg'>
                                                                                                                                                                                                                                                    <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                        <?php echo $td['name'] ?>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                            <?php
                                                                                                                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                    <div class='txt-c between-block'>
                                                                                                                                                                                                                                                        <img class='mt-15 mb-15 item-c' src='imgs/pdf.svg'>
                                                                                                                                                                                                                                                        <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                            <?php echo $td['name'] ?>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                <?php
                                                                                                                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                                                                                                                    ?>
                                                                                                                                                                                                                                                    <div class='file p-10 rad-10 '>
                                                                                                                                                                                                                                                        <div class='txt-c between-block'>
                                                                                                                                                                                                                                                            <img class='mt-15 mb-15 item-c' src='imgs/png.svg'>
                                                                                                                                                                                                                                                            <div class='mb-10 fs-14'>
                                                                                                                                                                                                                                                                <?php echo $td['name'] ?>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                    <?php
                                                                                                                                                                                }
                                                                                                                                                                                ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $td['size'] / 1000 . " Kbs"; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class='align-middle'>
                                                                                                                                                                                <?php echo $td['downloads']; ?>
                                                                                                                                                                            </td>
                                                                                                                                                                            <td class="align-middle">
                          
                                                                                                                                                                                <!-- Start Visibility -->
                                                                                                                                                                                <div class="d-inline">
                                                                                                                                                                                    <form class="d-inline" action="update.php?id_file=<?php echo $td['id'];?>" method="POST" id="form-td"
                                                                                                                                                                                        enctype="multipart/form-data" class="file-form">
                                                                                                                                                                                        <div class="file btn btn btn-outline-dark">
                                                                                                                                                                                            <i class='bx bxs-edit-alt'>
                                                                                                                                                                                                <input type="file" name="fil" class="myfile" id="fil" />
                                                                                                                                                                                            </i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <form class="d-inline" id="fileForm_<?php echo $td['id']; ?>" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                                                                                                                                                    method="POST">
                                                                                                                                                                                        <button type="submit" name="file_state" class="eye-button btn btn-outline-dark" value="<?php echo $td['id']; ?>">
                                                                                                                                                                                        <i class="fas fa-eye <?php if ($td['file_etat'] == 'cache')
                                                                                                                                                                                            echo 'd-none'; ?>" value="<?php echo $td['file_etat']; ?>" id="show_eye_<?php echo $td['id']; ?>"></i>
                                                                                                                                                                                        <i class="fas fa-eye-slash <?php if ($td['file_etat'] == 'visible')
                                                                                                                                                                                            echo 'd-none'; ?>" value="<?php echo $td['file_etat']; ?>" id="hide_eye_<?php echo $td['id']; ?>"></i>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </form>
                                                                                                                                                                                    <!-- End Visibility -->
                                                                                                                                                                                    <!-- Start Suppression -->
                                                                                                                                                                                    <button type='button' class='btn btn-info alertbox'
                                                                                                                                                                                        data-id='<?php echo $td['id']; ?>'
                                                                                                                                                                                        data-bs-target="myModal-<?php echo $td['id']; ?>"><i
                                                                                                                                                                                            class='bx bx-trash'></i>
                                                                                                                                                                                    </button>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class='modal fade' id='myModal-<?php echo $td['id']; ?>'
                                                                                                                                                                                    tabindex='-1' role='dialog'>
                                                                                                                                                                                    <div class='modal-dialog' role='document'>
                                                                                                                                                                                        <div class='modal-content'>
                                                                                                                                                                                            <div class='modal-header'>
                                                                                                                                                                                                <h5 class='modal-title'>Confirmation de la
                                                                                                                                                                                                    supression</h5>
                                                                                                                                                                                                <button type='button' class='close'
                                                                                                                                                                                                    data-bs-dismiss='modal' aria-label='Close'>
                                                                                                                                                                                                    <span aria-hidden='true'>&times;</span>
                                                                                                                                                                                                </button>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-body'>
                                                                                                                                                                                                <p id='error-"<?php echo $td['id']; ?>'></p>
                                                                                                                                                                                                <div class='alert alert-danger' role='alert'>
                                                                                                                                                                                                    voulez vous vraiment supprimer le fichier
                                                                                                                                                                                                    :<br>
                                                                                                                                                                                                    <?php echo $td['name']; ?>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class='modal-footer'>
                                                                                                                                                                                                <form action='delete.php' method='post'>
                                                                                                                                                                                                    <button type='submit' name='file_delete'
                                                                                                                                                                                                        class='btn btn-primary'
                                                                                                                                                                                                        value='<?php echo $td['id']; ?>'>
                                                                                                                                                                                                        Supprimer
                                                                                                                                                                                                    </button>
                                                                                                                                                                                                    <button type='button'
                                                                                                                                                                                                        class='btn btn-secondary'
                                                                                                                                                                                                        data-bs-dismiss='modal'>ignorer</button>
                                                                                                                                                                                                </form>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <!-- End Suppression -->
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End Td table -->
            </div>
        </div>
    </div>
    <!--Sidebar Script-->
    <script src=" js/app.js"></script>
    <!-- JQUERY -->
    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.alertbox').click(function () {
                var id = $(this).data('id');
                $('#error-' + id).html('');
                $('#myModal-' + id).modal('show');
            });
        });
    </script>
    <script src='js/popper.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script>
    var id = <?php echo $fileId; ?>;
  const formu = document.getElementById('fileForm_'.id);
  formu.addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche la soumission du formulaire
    formu.submit(); // Soumission du formulaire
  });
</script>

<script>
    const formu1 = document.getElementById('form-cours');
    formu1.addEventListener('change', function() {
        event.preventDefault(); // Empêche la soumission du formulaire
        formu1.submit(); // Soumission du formulaire
    });         
    const formu2 = document.getElementById('form-tp');
    formu2.addEventListener('change', function() {
        event.preventDefault(); // Empêche la soumission du formulaire
        formu2.submit(); // Soumission du formulaire
    });         
    const formu3 = document.getElementById('form-td');
    formu3.addEventListener('change', function() {
        event.preventDefault(); // Empêche la soumission du formulaire
        formu3.submit(); // Soumission du formulaire
    });         
</script>
</body>

</html>