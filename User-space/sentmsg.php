<?php
include('connection.php');
?>
<?php
//fonction de validation 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php

$etudiant_id = $_SESSION['user_id'];
if (isset($_POST['submit'])) {
    if (empty($_POST['form-control-recepteur']) || empty($_POST['msg'])) {
        $_SESSION['error'] = "l'un des champs est vide!!";
    } else {
        $recepteur = test_input($_POST['form-control-recepteur']);
        $message = test_input($_POST['msg']);
        $objet = test_input($_POST['objet']);
        if (empty(test_input($_POST['objet']))) {
            $objet = '(sans objet)';
        }
        $sql = "SELECT * from professeur where email='$recepteur' ";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        $id_prof = $row['num_serie'];
        $id_recepteur = $id_prof;
        $id_expediteur = $etudiant_id;
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO message(texte,objet,id_etudiant,id_prof,datee,id_expediteur,id_recepteur) values('$message', '$objet',$etudiant_id,'$id_prof','$date','$id_expediteur', '$id_recepteur'); ";
        if (($connection->query($sql) === TRUE)) {
            $req = "SELECT * FROM  message  WHERE message.id_recepteur='$id_recepteur' AND message.id_expediteur='$id_expediteur' AND message.datee='$date'";
            $res = mysqli_query($connection, $req);
            $ro = mysqli_fetch_assoc($res);
            $id_message = $ro['idMessage'];
            $status = 'unread';
            $reqe = "INSERT INTO  notification (date_n, status,id_message) VALUES ('$date','$status',$id_message);";
            if (($connection->query($reqe) === TRUE)) {
                header('Location:index.php');
            }
        }

    }




}
?>
<?php
if (isset($_POST['delete_msg'])) {
    $get_msg_id = $_POST['check'];
    for ($i = 0; $i < COUNT($get_msg_id); $i++) {
        $delete_msg = mysqli_query($connection, "DELETE FROM message WHERE idMessage=" . $get_msg_id[$i] . "");
        if ($delete_msg) {
            header('Location:test-msg.php');
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
    <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/framework.css" />
  <link rel="stylesheet" href="css/master.css" />
  <link rel="stylesheet" href="css/boxicons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto|Varela+Round'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet' href='css/bootstrap/font-awesome.min.css'>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='css/bootstrap/bootstrap.min.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
  <link rel='stylesheet' href='css/bootstrap/font-awesome.min.css'>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="noti.css" />

<body>
    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">
            <!-- Start Head -->
            <?php include('head.php') ?>  
            <!-- End Head -->
            <!--Students table-->
            
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
            <div class="p-10">
   
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-content" id="myTabContent">
                            <?php


                            if (isset($_GET['id_message'])) {
                                $id = $_GET['id_message'];
                                $res = mysqli_query($connection, "DELETE FROM message WHERE idMessage=$id");
                                if ($res) {


                                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
         <strong>la suppression</strong> est bien faite .
         <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
         </button>
         </div>";


                                }

                            }
                            ?>
                                <div class="tab-pane fade active show" id="inbox" aria-labelledby="inbox-tab"
                                    role="tabpanel">
                                    <div>
                                        <div class="row p-4 no-gutters align-items-center">
                                            <div class="col-sm-12 col-md-6">
                                            <h3 class="font-light mb-0">
                                                    <?php
                                                    $get_unread_msg = mysqli_query($connection, "SELECT COUNT(*) AS unread FROM `notification`,message WHERE notification.id_message = message.idMessage AND message.id_recepteur='$etudiant_id'  AND status = 'unread';");
                                                    if ($get_unread_msg) {
                                                        $get_unread_msg = mysqli_fetch_assoc($get_unread_msg);
                                                        if ($get_unread_msg['unread'] == 1) {
                                                            echo $get_unread_msg['unread'] . " message non lu";
                                                        } elseif ($get_unread_msg['unread'] > 1) {
                                                            echo $get_unread_msg['unread'] . " messages non lus";
                                                        }
                                                    }
                                                    ?>
                                                </h3>
                                            </div>

                                            <div class="col-sm-12 col-md-6">
                                                <ul class="list-inline dl mb-0 float-left float-md-right">
                                                    <li class="list-inline-item text-info mr-3">
                                                        <a href="#">
                                                            
                                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


                                          <li class="list-inline-item text-info mr-3">
                                                        <form action='test-msg.php' method='POST'>
                                                            <a href='#myModal' data-toggle='modal'
                                                                class='btn btn-circle btn-primary text-white'>
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <span class="ml-2 font-normal text-dark">Composer</span>
                                                            <div id='myModal' class='modal fade'>
                                                                <div class='modal-dialog modal-dialog-centered'>
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
                                                                                <h3 style="color:black;">Envoyer un message</h3>
                                                                                <div class="input-group mb-3">
<input type="text" name="ename" class="form-control select-input custom-select rounded"
  placeholder="Nom d'utilisateur" />
<div class="dropdown-menu dropdown-menu-right select-options">
  <?php
  $id_etu = $_SESSION['user_id'];
  $getusers_query = mysqli_query($connection, "SELECT * from etudie,module,professeur WHERE module.id_module=etudie.idModule and module.idProfesseur=professeur.num_serie and etudie.idEtudiant=$id_etu;");
  if ($getusers_query) {
      while ($users = mysqli_fetch_assoc($getusers_query)) {
          ?>
          <li data-value="<?php echo $users['prenom'] . " " . $users['nom']; ?>" value="<?php echo $users['prenom'] . " " . $users['nom']; ?>"><?php echo $users['prenom'] . " " . $users['nom']; ?></li>
          <?php
      }
  }
  ?>
</div>
</div>
<div class="input-group mb-3">
<input type="text" name="form-control-recepteur" class="form-control select-input custom-select rounded"
  placeholder="Adresse e-mail" />
<div class="dropdown-menu dropdown-menu-right select-options">
  <li data-value="Tous les etudiants" value="Tous les etudiants">Tous les professeurs</li>
  <?php
  $id_etu = $_SESSION['user_id'];
  $getusers_query = mysqli_query($connection, "SELECT * from etudie,module,professeur WHERE module.id_module=etudie.idModule and module.idProfesseur=professeur.num_serie and etudie.idEtudiant=$id_etu;");
  if ($getusers_query) {
      while ($users = mysqli_fetch_assoc($getusers_query)) {
          ?>
          <li data-value="<?php echo $users['email']; ?>" value="<?php echo $users['email']; ?>"><?php echo $users['email']; ?></li>
          <?php
      }
  }
  ?>
</div>
</div>
                                                                                <div class="input-group mb-3">
            
                                                                       <textarea class="form-control" id="objet" placeholder="Objet" name="objet"></textarea>
                                                                                </div>
                                                                                <div class="message-box">
                                                                                    <textarea name="msg" id="msg"
                                                                                        cols="10" rows="10"
                                                                                        placeholder="Tapez votre message ici ..."></textarea>
                                                                                </div>
                                                                                <div class="button">
                                                                                    <button type="submit" id="send"
                                                                                        name='submit'>
                                                                                        Envoyer
                                                                                    </button>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </form>
                                                    </li>
                                                           
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item text-danger">

<button type="button"
    class="btn btn-circle btn-danger text-white"
    data-bs-toggle="modal" data-bs-target="#delete_msg_modal"
    href="javascript:void(0)">
    <i class="fa fa-trash"></i>
</button>
<div class="modal fade" id="delete_msg_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Confirmation
                    de la suppression</h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                <div class="alert alert-danger" role="alert">
                    Voulez vous vraiment supprimer ces messages
                    ?
                </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Ignorer</button>
                <form action="<?php $_SERVER['PHP_SELF']; ?>"
                    method="post">
                    <button type="submit" name="delete_msg"
                        class="btn btn-primary">
                        Supprimer
                    </button>
            </div>
        </div>
    </div>
</div>
<span class="ml-2 font-normal text-dark">Supprimer</span>
</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                            <div class="custom-control custom-checkbox mb-2 ml-3">
                                                    <input type="checkbox" class="custom-control-input" id="checkAl" />
                                                    <label class="custom-control-label text-muted fst-italic"
                                                        for="checkAl">&nbsp;Sélectionner
                                                        tous les messages réceptionnés</label>
                                                </div>
                                                <tbody>
                                                    <?php
                                                    $etudiant_id = $_SESSION['user_id'];
                                                    $sql = "SELECT * from message,etudiant WHERE message.id_etudiant=etudiant.Apogee AND   message.id_expediteur='$etudiant_id'";
                                                    $result = mysqli_query($connection, $sql);
                                                    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);


                                                    ?>
                                                    <?php foreach ($messages as $message): ?>

                                                        <tr>

                                                            <td class="pl-3">
                                                            <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="check[]"
                                                                                class="custom-control-input"
                                                                                id="<?php echo $message['idMessage']; ?>"
                                                                                value="<?php echo $message['idMessage']; ?>" />
                                                                            <label class="custom-control-label"
                                                                                for="<?php echo $message['idMessage']; ?>">&nbsp;</label>
                                                                        </div>
                                                            </td>

                                                        
                                                            <td>
                                                                <span class="mb-0 text-muted"><?php echo $message['nom'] . ' ' . $message['prenom']; ?></span>
                                                            </td>

                                                            <td>
                                                                <a  href="mesagestest.php?id_message=<?php echo $message['idMessage'] ?> " class="link"  >
                                                                
                                                                    <span class="text-dark"><?php echo $message['objet']; ?></span>
                                                                </a>
                        
                                                            
                                                                           
                                                            </td>

                                                            <td><i class="fa fa-paperclip text-muted"></i></td>

                                                            <td class="text-muted"><?php echo $message['datee']; ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sent" aria-labelledby="sent-tab" role="tabpanel">
                                    <div class="row p-3 text-dark">
                                        <div class="col-md-6">
                                            <h3 class="font-light">Lets check profile</h3>
                                            <h4 class="font-light">you can use it with the small code</h4>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                                                enim
                                                justo, rhoncus ut, imperdiet a.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="spam" aria-labelledby="spam-tab" role="tabpanel">
                                    <div class="row p-3 text-dark">
                                        <div class="col-md-6">
                                            <h3 class="font-light">Come on you have a lot message</h3>
                                            <h4 class="font-light">you can use it with the small code</h4>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                                                enim
                                                justo, rhoncus ut, imperdiet a.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="delete" aria-labelledby="delete-tab" role="tabpanel">
                                    <div class="row p-3 text-dark">
                                        <div class="col-md-6">
                                            <h3 class="font-light">Just do Settings</h3>
                                            <h4 class="font-light">you can use it with the small code</h4>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                                                enim
                                                justo, rhoncus ut, imperdiet a.</p>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>

<script src='js/bootstrap.min.js'></script>
<script src='js/popper.min.js'></script>
<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
<script src="js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/calendar.js"></script>
<script src="js/prog.js"></script>
<script src="js/noti.js"></script>
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="js/select_input.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="js/msg.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

            
</body>
</html>