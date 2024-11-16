<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$getidModule = mysqli_query($connection, "SELECT id_module FROM module WHERE idProfesseur = '$prof_id';");
// if ($getidModule) {
//     $getidModule = mysqli_fetch_assoc($getidModule);
//     $idModule = $getidModule['id_module'];
// }

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../login/adminLogin.php');
    die();
}
?>

<?php
if (isset($_POST['send'])) {
    function filtr_input($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        filter_var($data, FILTER_SANITIZE_STRING);
        return $data;
    }
    $d_name = $_POST['ename'];
    $email = $_POST['email'];
    $msg_texte = filtr_input($_POST['msg']);
    $object = filtr_input($_POST['objet']);
    $date_heure = date("Y-m-d H:i:s");
    // if ($email === "Tous les etudiants") {
    //     $s_getstudent = mysqli_query($connection, "SELECT * FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id';");
    //     if ($s_getstudent) {
    //         while ($insert_msg = mysqli_fetch_assoc($s_getstudent)) {
    //             $all_apogee = $insert_msg['Apogee'];
    //             $res1 = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$object','$msg_texte','$date_heure','" . $insert_msg['Apogee'] . "','$prof_id','$prof_id','" . $insert_msg['Apogee'] . "')");
    //             if ($res1) {
    //                 $get_msg_id = mysqli_query($connection, "SELECT * FROM message WHERE datee='$date_heure' AND id_recepteur='" . $insert_msg['Apogee'] . "' AND id_expediteur='$prof_id'");
    //                 if ($get_msg_id) {
    //                     $id_msg = mysqli_fetch_assoc($get_msg_id);
    //                     $date = $id_msg['datee'];
    //                     $id_msg = $id_msg['idMessage'];
    //                     $notifi_res = mysqli_query($connection, "INSERT INTO notification (date_n,id_message) VALUES ('$date','$id_msg')");
    //                 }
    //             }
    //         }
    //         if ($notifi_res) {
    //             header('Location:sentMsg.php');
    //             die();
    //         }
    //     }
    // }
    $apogee = mysqli_query($connection, "SELECT Apogee FROM etudiant WHERE  email ='$email';");
    if (mysqli_num_rows($apogee) > 0) {
        $apogee = mysqli_fetch_assoc($apogee);
        $apogee = (int) trim($apogee['Apogee']);
        $res = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$object','$msg_texte','$date_heure','$apogee','$prof_id','$prof_id','$apogee')");
        if ($res) {
            $get_msg_id = mysqli_query($connection, "SELECT * FROM message WHERE datee='$date_heure' AND id_recepteur='$apogee' AND id_expediteur='$prof_id'");
            if ($get_msg_id) {
                $id_msg = mysqli_fetch_assoc($get_msg_id);
                $date = $id_msg['datee'];
                $id_msg = $id_msg['idMessage'];
                $notifi_res = mysqli_query($connection, "INSERT INTO notification (date_n,id_message) VALUES ('$date','$id_msg')");
                if ($notifi_res) {
                    header('Location:sentMsg.php');
                    die();
                }
            }
        }
    }
    if ($email != 'all') {
        $idModule = explode("-", $email)[1]; // Extrait l'id_module en utilisant la fonction explode
        // echo "id_module sélectionné : " . $idModule;
        $s_getstudent = mysqli_query($connection, "SELECT * FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id' AND module.id_module='$idModule';");
        if ($s_getstudent) {
            while ($insert_msg = mysqli_fetch_assoc($s_getstudent)) {
                $apogee = $insert_msg['Apogee'];
                $res1 = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$object','$msg_texte','$date_heure','" . $insert_msg['Apogee'] . "','$prof_id','$prof_id','$apogee')");
                if ($res1) {
                    $get_msg_id = mysqli_query($connection, "SELECT * FROM message WHERE datee='$date_heure' AND id_recepteur='" . $insert_msg['Apogee'] . "' AND id_expediteur='$prof_id'");
                    if ($get_msg_id) {
                        $id_msg = mysqli_fetch_assoc($get_msg_id);
                        $date = $id_msg['datee'];
                        $id_msg = $id_msg['idMessage'];
                        $notifi_res = mysqli_query($connection, "INSERT INTO notification (date_n,id_message) VALUES ('$date','$id_msg')");

                    }
                }
            }
            if ($notifi_res) {
                header('Location:sentMsg.php');
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
    <title>Messages</title>
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
            <!--Messages table-->
            <div class="p-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 mt-5">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="inbox" aria-labelledby="inbox-tab"
                                    role="tabpanel">
                                    <div>
                                        <div class="row p-4 no-gutters align-items-center">
                                            <div class="col-sm-12 col-md-6">
                                                <!-- <h3 class="font-bold w-fs fs-4">
                                                    <?php
                                                    // $get_unread_msg = mysqli_query($connection, "SELECT COUNT(*) AS unread FROM `notification`,message WHERE notification.id_message = message.id_msg AND message.id_destination='$prof_id' AND status = 'unread';");
                                                    // if ($get_unread_msg) {
                                                    //     $get_unread_msg = mysqli_fetch_assoc($get_unread_msg);
                                                    //     if ($get_unread_msg['unread'] == 1) {
                                                    //         echo $get_unread_msg['unread'] . " message non lu";
                                                    //     } elseif ($get_unread_msg['unread'] > 1) {
                                                    //         echo $get_unread_msg['unread'] . " messages non lus";
                                                    //     }
                                                    // }
                                                    ?>
                                                </h3> -->
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <ul class="list-inline dl mb-0 float-left float-md-right">
                                                    <li class="list-inline-item text-info mr-3">
                                                        <form action='<?php $_SERVER['PHP_SELF']; ?>' method='post'>
                                                            <a href='#myModal' data-toggle='modal'
                                                                class='btn btn-circle btn-primary text-white'>
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <span class="ml-2 font-normal text-dark">Composer</span>
                                                            <div id='myModal' class='modal fade'>
                                                                <div class='modal-dialog modal-dialog-centered '>
                                                                    <div class='modal-content'>
                                                                        <div class="modal-header justify-content-center">
                                                                            <h3 class='text-dark'>Envoyer un message
                                                                            </h3>
                                                                            <button type='button' class='close'
                                                                                data-dismiss='modal'
                                                                                aria-hidden='true'>&times;
                                                                            </button>
                                                                        </div>
                                                                        <div class='modal-body text-center'>
                                                                            <p>
                                                                            <div class="box text-dark">
                                                                                <div class="name">
                                                                                    <div class="input-group mb-3">
                                                                                        <input type="text" name="ename"
                                                                                            class="form-control select-input custom-select rounded bg-white border"
                                                                                            placeholder="Nom d'utilisateur" />
                                                                                        <div class="dropdown-menu dropdown-menu-right select-options">
                                                                                            <?php
                                                                                            $res = mysqli_query($connection, "SELECT * FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id';");
                                                                                            if ($res) {
                                                                                                while ($row = mysqli_fetch_assoc($res)) {
                                                                                                    ?>
                                                                                                    <li data-value="<?php echo $row['nom'] . " " . $row['prenom']; ?>" value="<?php echo $row['nom'] . " " . $row['prenom']; ?>"><?php echo $row['nom'] . " " . $row['prenom']; ?></li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="email">
                                                                                    <div class="input-group mb-3">
                                                                                        <input type="text" name="email"
                                                                                            class="form-control select-input custom-select rounded bg-white border"
                                                                                            placeholder="Adress e-mail" />
                                                                                        <div class="dropdown-menu dropdown-menu-right select-options">
                                                                                            <!-- <li data-value="Tous les etudiants" value="all">Tous les étudiants</li> -->
                                                                                            <?php
                                                                                            $all_stu=mysqli_query($connection,"SELECT DISTINCT module.nomModule,module.id_module FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id' GROUP BY module.id_module;");
                                                                                            if($all_stu){
                                                                                                while($all = mysqli_fetch_assoc($all_stu)){
                                                                                                  ?>
                                                                                                  <li name="all" data-value="all-<?php echo $all['id_module']; ?>" value="<?php echo $all['id_module']; ?>"><?php echo $all['nomModule']; ?></li>
                                                                                                  <?php  
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                            <?php
                                                                                            $res = mysqli_query($connection, "SELECT * FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id';");
                                                                                            if ($res) {
                                                                                                while ($row = mysqli_fetch_assoc($res)) {
                                                                                                    ?>
                                                                                                    <li data-value="<?php echo $row['email']; ?>"><?php echo $row['email']; ?></li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="message-box">
                                                                                    <div class="input-group mb-0">
                                                                                        <input type="text" name="objet"
                                                                                            class="d-block mb-20 w-full p-10 b-none bg-eee rad-6"
                                                                                            placeholder="Objet" />
                                                                                    </div>
                                                                                    <textarea name="msg" id="msg"
                                                                                        cols="10" rows="10"
                                                                                        placeholder="Tapez votre message ici ..."></textarea>
                                                                                </div>
                                                                                <div class="button">
                                                                                    <button type="submit" id="send"
                                                                                        name='send'>
                                                                                        Envoyer
                                                                                    </button>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="archive d-flex justify-content-center m-20 gap-20 p-10 rad-10">
                                                <div class="card mb-3 border-0 mb-30"
                                                    style="max-width: 540px; min-height : 200px">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <img src="imgs\attachement.png"
                                                                class="img-fluid rounded-start" alt="...">
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <div class="card-body ">
                                                                <p class="card-text text-center mt-3 w-fs">
                                                                    <a href="inbox.php" class="text-dark">
                                                                        <h5 class="card-title">Boîte de Reception</h5>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card  border-0 mb-20" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <img src="imgs\envoyer-un-mail.png"
                                                                class="img-fluid rounded-start" alt="...">
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <div class="card-body ">
                                                                <!-- <h5 class="card-title">Boîte de Reception</h5> -->
                                                                <p class="card-text text-center mt-3 w-fs">
                                                                    <a href="sentMsg.php" class="text-dark">
                                                                        <h5 class="card-title">Messages envoyés</h5>
                                                                    </a>
                                                                </p>
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
            </div>
        </div>
        <!--Sidebar Script-->
        <script src="js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src='js/popper.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <script src="js/select_input.js"></script>
</body>

</html>