<?php
include('connection.php');
$apogee = $_SESSION['user_id'];
?>

<?php
if (isset($_POST['send'])) {

    $d_name = $_POST['ename'];
    $email = $_POST['email'];
    $msg_texte = $_POST['msg'];
    $date_heure = date("Y-m-d H:i:s");
    $prof_id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * from professeur where email='$email' "));
    if ($prof_id) {
        $res = mysqli_query($connection, "INSERT INTO message(texte,id_etudiant,id_prof,datee,id_expediteur,id_recepteur)  VALUES ('$msg_texte','$apogee','$prof_id','$date_heure','$apogee','$prof_id')");
        if ($res) {
            header('Location:message1.php');
        }
    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Students</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/framework.css" />
    <link rel="stylesheet" href="css/master.css" />
    <link rel="stylesheet" href="css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto|Varela+Round'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <!-- font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>


<body>

    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->

        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full ">

            <!-- Start Head -->
            <div class="head bg-white p-15 between-flex">
                <div class="search">

                </div>
                <div class="icons d-flex align-center">
                    <span class="notification p-relative">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>

                </div>
            </div>
            <!-- End Head -->
            <!--Students table-->
            <div class="pt-20">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="inbox" aria-labelledby="inbox-tab"
                                    role="tabpanel">
                                    <div>
                                        <div class="row p-4 no-gutters align-items-center">
                                            <div class="col-sm-12 col-md-6">
                                                <h3 class="font-light mb-0">350 Unread emails</h3>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <ul class="list-inline dl mb-0 float-left float-md-right">
                                                    <li class="list-inline-item text-info mr-3">
                                                        <form action='#' method='post'>
                                                            <a href='#myModal' data-toggle='modal'
                                                                class='btn btn-circle btn-primary text-white'>
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <span class="ml-2 font-normal text-dark">Compose</span>
                                                            <div id='myModal' class='modal fade'>
                                                                <div class='modal-dialog modal-confirm'>
                                                                    <div class='modal-content'>
                                                                        <div
                                                                            class='modal-header justify-content-center'>
                                                                            <button type='button' class='close'
                                                                                data-dismiss='modal'
                                                                                aria-hidden='true'>&times;</button>
                                                                        </div>
                                                                        <div class='modal-body text-center'>
                                                                            <p>
                                                                            <div class="box">
                                                                                <h3>Envoyer un message</h3>
                                                                                <div class="name">
                                                                                    <div class="input-group mb-3">
                                                                                        <select name="ename"
                                                                                            class="custom-select"
                                                                                            required>
                                                                                            <option selected>---
                                                                                            </option>
                                                                                            <?php
                                                                                            $res = mysqli_query($connection, "SELECT email FROM etudiant,etudie WHERE etudie.idEtudiant = etudiant.Apogee AND etudie.idModule='$id_module';");
                                                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                                                echo "<option value=" . $row['nom'] . ">" . $row['prenom'] . "</option>";
                                                                                            }
                                                                                            #echo "<option value=" . $row['nom'] . $row['prenom'] . ">" . $row['nom'] . $row['prenom'] . "</option>";
                                                                                            
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="email">
                                                                                    <div class="input-group mb-3">


                                                                                        <select name="email"
                                                                                            class="custom-select"
                                                                                            required>
                                                                                            <option selected>Address
                                                                                                E-mail</option>
                                                                                            <?php
                                                                                            $res = mysqli_query($connection, "SELECT email FROM etudiant,etudie WHERE etudie.idEtudiant = etudiant.Apogee AND etudie.idModule='$id_module';");
                                                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                                                echo "<option value=" . $row['email'] . ">" . $row['email'] . "</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="message-box">
                                                                                    <textarea name="msg" id="msg"
                                                                                        cols="30" rows="10"
                                                                                        placeholder="Tapez votre message ici ..."></textarea>
                                                                                </div>
                                                                                <div class="button">

                                                                                    <button type="submit" id="send"
                                                                                        name='send'>Envoyer
                                                                                    </button>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </form>
                                                    </li>
                                                    <li class="list-inline-item text-danger">
                                                        <a href="#">
                                                            <button class="btn btn-circle btn-danger text-white"
                                                                href="javascript:void(0)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            <span class="ml-2 font-normal text-dark">Delete</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                                <tbody>
                                                    <?php include('sidebar.php');
                                                    $student_id = $_SESSION['user_id'];
                                                    $getid_module = mysqli_query($connection, "SELECT * FROM etudie,module,professeur WHERE professeur.num_serie=module.idProfesseur AND module.id_module = etudie.idModule AND etudie.idEtudiant='$apogee' ;");
                                                    while ($row = mysqli_fetch_assoc($getid_module)) {
                                                        ?>
                                                        <?php
                                                        $res = mysqli_query($connection, "SELECT * FROM message,professeur WHERE message.id_recepteur = '" . $row['num_serie'] . "' AND professeur.num_serie = message.id_recepteur;;");
                                                        if ($res) {
                                                            $cpt = 0;
                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                $cpt++;
                                                                ?>
                                                                <tr>
                                                                    <td class="pl-3">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input"
                                                                                id="<?php echo $cpt; ?>" />
                                                                            <label class="custom-control-label"
                                                                                for="<?php echo $cpt; ?>">&nbsp;</label>
                                                                        </div>
                                                                    </td>

                                                                    <td></td>
                                                                    <td>
                                                                        <span class="mb-0 text-muted">
                                                                            <?php echo $row['nom'] . " " . $row['prenom']; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a class="link" href="javascript: void(0)">
                                                                            <span class="text-dark">
                                                                                <?php echo $row['texte']; ?>
                                                                            </span>
                                                                        </a>
                                                                    </td>
                                                                    <td><i class="fa fa-paperclip text-muted"></i></td>
                                                                    <td class="text-muted">
                                                                        <?php echo $row['datee']; ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <?php


                                                ?>
                                            </table>

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

</body>

</html>