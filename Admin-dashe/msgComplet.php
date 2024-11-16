<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$getidModule = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id_module FROM module WHERE idProfesseur = '$prof_id';"));
$idModule = $getidModule['id_module'];
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../login/adminLogin.php');
    die();
}

if (isset($_POST['send'])) {
    $msg_text = $_POST['msg'];
    $msg_objet = $_POST['objet'];
    $dest = $_POST['send'];
    $date_heure = date("Y-m-d H:i:s");
    $send_res = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$msg_objet','$msg_text','$date_heure','$dest','$prof_id','$prof_id','$dest')");
    if ($send_res) {
        $get_msg_id = mysqli_query($connection, "SELECT * FROM message WHERE datee='$date_heure' AND id_recepteur='$dest' AND id_expediteur='$prof_id'");
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

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voir message</title>
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
        <div class="content w-full ">
            <!-- Start Head -->
            <?php include('header.php'); ?>
            <!-- End Head -->
            <div class="container-lg p-20 pl-0 pr-0">
                <div class=" w-full bg-white rad-6">
                    <!-- Content Place Here -->
                    <div class="email-app card">
                        <div class="email-desc-wrapper w-full p-40 fst-italic">
                            <?php
                            $id_msg = $_GET['id'];
                            $getMessage = mysqli_query($connection, "SELECT *  FROM message WHERE message.idMessage='$id_msg' ;");
                            if ($getMessage) {
                                $msg = mysqli_fetch_assoc($getMessage)
                                    ?>
                                <div class="email-header  w-full pb-20">
                                    <div class="email-date fs-15 c-grey mb-5">
                                        <?php echo $msg['datee']; ?>
                                    </div>
                                    <div class="fw-bold fs-30 w-fs mb-5  text-center text-black">
                                        <?php echo $msg['objet']; ?>
                                    </div>
                                    <p class="c-grey fst-italic">
                                        <?php
                                        $s_getProf = mysqli_query($connection, "SELECT *  FROM professeur WHERE num_serie ='" . $msg['id_expediteur'] . "';");
                                        if (mysqli_num_rows($s_getProf) > 0) {
                                            $s_getProf = mysqli_fetch_assoc($s_getProf);
                                            ?>
                                            <span class="c-black fw-bold fs-20 block-mobile">From:</span>
                                            <?php echo $s_getProf['nom'] . " " . $s_getProf['prenom']; ?>
                                            &lt;
                                            <?php echo $s_getProf['email']; ?>&gt;
                                            <?php
                                        }
                                        $s_getstu = mysqli_query($connection, "SELECT * FROM etudiant WHERE Apogee = '" . (int) trim($msg['id_expediteur']) . "'");
                                        if (mysqli_num_rows($s_getstu)>0) {
                                            $s_getstu = mysqli_fetch_assoc($s_getstu);
                                            $_SESSION['student_source'] = $s_getstu['Apogee'];
                                            ?>
                                            <span class="c-black fw-bold fs-20 block-mobile">From:</span>
                                            <?php echo $s_getstu['nom'] . " " . $s_getstu['prenom']; ?>
                                            &lt;
                                            <?php echo $s_getstu['email']; ?>&gt;
                                            <?php
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="email-body mb-20">
                                    <p class="fst-italic">
                                        <?php
                                        $d_getProf = mysqli_query($connection, "SELECT *  FROM professeur WHERE num_serie ='" . $msg['id_recepteur'] . "';");
                                        if (mysqli_num_rows($d_getProf) > 0) {
                                            $d_getProf = mysqli_fetch_assoc($d_getProf);
                                            $_SESSION['id_desti'] = $d_getProf['num_serie'];
                                            mysqli_query($connection, "Update notification set status = 'read' WHERE id_message = $id_msg");
                                            ?>
                                            <span class="c-black fw-bold fs-20 block-mobile fw-semibold">to</span>
                                            <?php echo $d_getProf['nom'] . " " . $d_getProf['prenom'] . ","; ?>
                                            <?php
                                        }
                                        $d_getstu = mysqli_query($connection, "SELECT * FROM etudiant WHERE Apogee = '" . (int) trim($msg['id_recepteur']) . "'");
                                        if (mysqli_num_rows($d_getstu)) {
                                            $d_getstu = mysqli_fetch_assoc($d_getstu);
                                            $_SESSION['id_desti'] = $d_getstu['Apogee'];
                                            ?>
                                            <span class="c-black  block-mobile">to</span>
                                            <?php echo " " . $d_getstu['nom'] . " " . $d_getstu['prenom'] . ","; ?>

                                            <?php
                                        } ?>
                                    </p>
                                    <p>
                                        <?php echo $msg['texte']; ?>
                                    </p>
                                </div>
                                <div class="email-action text-center mt-100">
                                    <?php
                                    if ($_SESSION['id_desti'] == $prof_id) {
                                        ?>
                                        <button name='reply' value="<?php echo ""; ?>" class="btn btn-outline-dark"
                                            data-toggle='modal' data-target='#myModal1'>Repondre<i class="fa fa-reply"></i>
                                        </button>
                                        <div id='myModal1' class='modal fade'>
                                            <div class='modal-dialog modal-dialog-centered'>
                                                <div class='modal-content'>
                                                    <div class='modal-header justify-content-center'>
                                                        <h2 class=''>Repondre</h2>
                                                        <button type='button' class='close' data-dismiss='modal'
                                                            aria-hidden='true'>&times;</button>
                                                    </div>
                                                    <div class='modal-body text-center'>
                                                        <p>
                                                            <?php
                                                            $s_res = mysqli_query($connection, "SELECT * FROM etudiant,etudie WHERE etudiant.Apogee = " . (int) trim($_SESSION['student_source']) . " AND etudie.idEtudiant = etudiant.Apogee AND etudie.idModule='$idModule';");
                                                            if ($s_res) {
                                                                $username = mysqli_fetch_assoc($s_res);
                                                                ?>
                                                            <form action="#" method="post">
                                                                <div class="box text-dark">
                                                                    <div class="message-box">

                                                                        <div class="input-group mb-0">
                                                                            <input type="text"
                                                                                class="d-block mb-20 w-full p-10 b-none bg-eee rad-6"
                                                                                name="email"
                                                                                value="<?php echo $username['nom'] . " " . $username['prenom'] . " < " . $username['email'] . ">"; ?>"
                                                                                disabled>
                                                                            <?php
                                                                            ?>
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="objet"
                                                                                class="d-block mb-20 w-full p-10 b-none bg-eee rad-6"
                                                                                placeholder="Objet" />
                                                                        </div>
                                                                        <textarea name="msg" id="msg" cols="10" rows="10"
                                                                            placeholder="Tapez votre message ici ..."></textarea>
                                                                    </div>
                                                                    <div class="button">
                                                                        <button type="submit" id="send" name='send'
                                                                            value="<?php echo (int) trim($_SESSION['student_source']); ?>">
                                                                            Envoyer
                                                                        </button>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <?php
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="button" class="btn btn-outline-secondary" disabled>
                                            Repondre<i class="fa fa-reply"></i>
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <button class="btn btn-primary"><i class="fa fa-share"></i> transferer</button>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
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

</body>

</html>