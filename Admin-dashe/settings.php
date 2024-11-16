<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
// $getModule = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id_module FROM module WHERE idProfesseur='$prof_id';"));
// $id_Module = $getModule['id_module'];
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../login/adminLogin.php');
    die();
}

?>


<?php
if (isset($_FILES['file']['name'])) {
    $filename = $_FILES['file']['name'];
    $destination = "profile/".$filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    if (!in_array($extension, ['png', 'jpg'])) {
        $_SESSION['error_upload'] = "Veuillez entrez un fichire d'extension : 'png' ou 'jpg'";
        header('Location:settings.php');
        die();
    } elseif ($_FILES['myfile']['size'] > 5000000) { //>5MO
        $_SESSION['error_upload'] = "La taille du fichier dépasse 5 MO !!";
        header('Location:settings.php');
        die();
    } elseif (file_exists($destination)) {
        $sql = "UPDATE professeur set profile='$destination' where num_serie='$prof_id' ";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            header('Location:settings.php');
            die();
        } else {
            header('Location:settings.php');
            die();
        }
    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE professeur set profile='$destination' where num_serie='$prof_id' ";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                header('Location:settings.php');
                die();
            } else {
                header('Location:settings.php');
                die();
            }
        }
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel='stylesheet' href='css/bootstrap/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel='stylesheet' href='css/bootstrap/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"
        integrity="sha512-F3m1YmLGvKjC49m0Xe8nIflDs6UvD6KjzLx7+z/yqGdY2smjK28CjjfNU9ZMVSNMfyzFcbnbwGnKjtcdbymTg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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
            <div class="container-fluid p-20 rad-10 m-20">
                <div class="mb-25">
                    <div class="row ">
                        <div class="col-xl-4 col-md-6">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0 " id='card'>
                                <div class="card-header text-center">Photo de profile</div>
                                <?php
                                if (isset($_SESSION['error_upload']) && $_SESSION['error_upload'] != "") {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible fade show col-md-10 align-self-center mt-1 border-0 bg-transparent text-danger"
                                        role="alert">
                                        <?php echo $_SESSION['error_upload'];
                                        unset($_SESSION['error_upload']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="card-body text-center">
                                    <?php
                                    $result = mysqli_query($connection, "SELECT * from professeur where num_serie ='$prof_id'");
                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        if (empty($row['profile'])) {
                                            ?>
                                            <!-- Profile picture image-->
                                            <img class="img-account-profile rounded-circle mb-2" src="imgs/avatar.jpg" alt="">
                                            <!-- Profile picture help block-->
                                            <div class="small font-italic text-muted mb-4">JPG ou PNG (ne depasse pas 5 MB)<span
                                                    class="text-danger">*</span>
                                            </div>
                                            <!-- Profile picture upload button-->
                                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id='form'
                                                enctype="multipart/form-data">
                                                <div class="file btn btn btn-primary">
                                                    Changer l'image
                                                    <input type="file" name="file" class="myfile" id="myfile" />
                                                </div>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <!-- Profile picture image-->
                                            <img class="img-account-profile rounded-circle mb-2"
                                                src="<?php echo $row['profile']; ?>" alt="">
                                            <!-- Profile picture help block-->
                                            <div class="small font-italic text-muted mb-4">JPG ou PNG (ne depasse pas 5
                                                MB)<span class="text-danger">*</span>
                                            </div>
                                            <!-- Profile picture upload button-->
                                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id='form'
                                                enctype="multipart/form-data">
                                                <div class="file btn btn btn-primary">
                                                    Changer l'image
                                                    <input type="file" name="file" class="myfile" id="myfile" />
                                                </div>
                                            </form>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <script>
                                        const formu = document.getElementById('myfile');
                                        formu.addEventListener('change',function(){//When the file input changes, this function will be triggered
                                            document.getElementById('form').submit();//submit form once the profile pic is changed
                                            //Calling the submit() method on the form triggers the form submission
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-6">
                            <!-- Account details card-->
                            <div class="card mb-4" id='card'>
                                <div class="mb-12">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation" class="active"><a
                                                class="nav-link active" href="#home" aria-controls="home" role="tab"
                                                data-toggle="tab">Profile</a></li>
                                        <li class="nav-item" data-bs-target="#profile" role="presentation">
                                            <a class="nav-link" href="#profile" aria-controls="profile" role="tab"
                                                data-toggle="tab">Changer mot de
                                                passe
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="p-20 mt-10 txt-center">
                                    <div class="col-md-16">
                                        <div class="col-md-12">
                                            <div class="portlet dark bordered">
                                                <div class="portlet-body">
                                                    <div>
                                                        <ul class="justify-content-end">
                                                            <!-- Tab panes -->
                                                            <div class="tab-content text-start">
                                                                <div role="tabpanel" class="tab-pane fade show active"
                                                                    id="home" aria-label="home">
                                                                    <?php
                                                                    if (isset($_SESSION['succ_status']) && $_SESSION['succ_status'] != " ") {
                                                                        ?>
                                                                        <div class="alert alert-primary alert-dismissible fade show"
                                                                            role="alert" id="alert1">
                                                                            <?php echo $_SESSION['succ_status']; ?>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="alert" aria-label="Close"
                                                                                data-bs-target="alert1"></button>
                                                                        </div>
                                                                        <?php
                                                                        unset($_SESSION['succ_status']);
                                                                    }
                                                                    if (isset($_SESSION['error_status']) && $_SESSION['error_status'] != "") {
                                                                        ?>
                                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                                            role="alert">
                                                                            <?php echo $_SESSION['error_status']; ?>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="alert"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <?php
                                                                        unset($_SESSION['error_status']);
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    $prof_res = mysqli_query($connection, "SELECT * FROM professeur,departement WHERE professeur.num_serie = '$prof_id' AND professeur.idDepartement = departement.idDepartement;");
                                                                    if ($prof_res) {
                                                                        while ($prof_row = mysqli_fetch_assoc($prof_res)) {
                                                                            ?>
                                                                            <form id="form_update"
                                                                                action="<?php $_SERVER['PHP_SELF']; ?>"
                                                                                method="post">
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20"
                                                                                            for="nom">Nom</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="name"
                                                                                                value="<?php echo $prof_row['nom']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20"
                                                                                            for="nom">Prenom</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="prenom"
                                                                                                value="<?php echo $prof_row['prenom']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20">Numero
                                                                                            de serie</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="numSerie"
                                                                                                value="<?php echo $prof_row['num_serie']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">CIN</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="cin"
                                                                                                value="<?php echo $prof_row['cin']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Adresse
                                                                                            E-mail</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="email"
                                                                                                value="<?php echo $prof_row['email']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Téléphone</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="phone"
                                                                                                value="<?php echo $prof_row['telephone']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Grade</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="grade"
                                                                                                value="<?php echo $prof_row['grade']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- <div class='col-md-4 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Module</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="nomModule"
                                                                                                value="<?php echo $prof_row['nomModule']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div> -->
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">departement</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="input_form" name="nomDep"
                                                                                                value="<?php echo $prof_row['nomDepartement']; ?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='px-2 d-flex flex-row-reverse'>
                                                                                    <button name="profil-update-btn"
                                                                                        class="btn btn-primary"
                                                                                        id="form-update-btn">Modifier</button>
                                                                                    <?php
                                                                                    if (isset($_POST['profil-update-btn'])) {
                                                                                        ?>
                                                                                        <div class="px-2">
                                                                                            <button type="submit" name="save"
                                                                                                class="btn btn-primary ">Enregistrer
                                                                                            </button>
                                                                                        </div>
                                                                                        <script>
                                                                                            const form_update = document.getElementById('form_update');
                                                                                            form_update.action = "update.php";
                                                                                            const update_btn = document.getElementById('form-update-btn');
                                                                                            update_btn.innerHTML = "ignorer";
                                                                                            update_btn.classList.replace("btn-primary", "btn-secondary");
                                                                                            var inputs = document.getElementsByClassName("modify");
                                                                                            for (var i = 0; i < inputs.length; i++) {
                                                                                                inputs[i].disabled = false;
                                                                                            }
                                                                                        </script>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade"
                                                                aria-label="profile" id="profile">
                                                                <?php
                                                                if (isset($_SESSION['pass_succ_status']) && $_SESSION['pass_succ_status'] != "") {
                                                                    ?>
                                                                    <div class="alert alert-primary alert-dismissible fade show"
                                                                        role="alert">
                                                                        <?php echo $_SESSION['pass_succ_status']; ?>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="alert"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <?php
                                                                    unset($_SESSION['pass_succ_status']);
                                                                }
                                                                if (isset($_SESSION['pass_error_status']) && $_SESSION['pass_error_status'] != "") {
                                                                    ?>
                                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                                        role="alert">
                                                                        <?php echo $_SESSION['pass_error_status']; ?>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="alert"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <?php
                                                                    unset($_SESSION['pass_error_status']);
                                                                }
                                                                ?>
                                                                <?php
                                                                $prof_res = mysqli_query($connection, "SELECT * FROM professeur WHERE num_serie = '$prof_id';");
                                                                if ($prof_res) {
                                                                    while ($prof_row = mysqli_fetch_assoc($prof_res)) {
                                                                        ?>
                                                                        <form class='' action='update.php' method='post'>
                                                                            <div class='form-row text-dark'>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <label for="password"
                                                                                        class=" floatingInput text-dark">Entrer
                                                                                        votre mot de passe courant :</label>
                                                                                    <div class='input-group'>
                                                                                        <input type='password'
                                                                                            name='ancien_password'
                                                                                            placeholder='Mot de passe courant'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <label for="password"
                                                                                        class=" floatingInput text-danger">changer
                                                                                        votre mot de passe :</label>
                                                                                    <div class='input-group'>
                                                                                        <input type='password'
                                                                                            name='1_new_password'
                                                                                            placeholder='Nouveau mot de passe'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <div class='input-group'>
                                                                                        <input type='password'
                                                                                            name='2_new_password'
                                                                                            placeholder='Retapez le nouveau mot de passe'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class='pt-10 pl-95'>
                                                                                <button class='btn btn-primary' type='submit'
                                                                                    name='admin-update'>Sauvegarder</button>
                                                                            </div>
                                                                        </form>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Sidebar Script-->
        <script src=" js/app.js"></script>
        <!-- JQUERY -->
        <script src="js/jquery.min.js"></script>
        <!-- JS -->
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src='js/popper.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
</body>

</html>