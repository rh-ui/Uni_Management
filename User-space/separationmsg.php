<?php
include('connection.php');
?>
<?php
//fonction de validation 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
?>
<?php

$etudiant_id = $_SESSION['user_id'];
if(isset($_POST['send']) ){
    if (empty($_POST['form-control-recepteur'])||empty($_POST['msg'])||empty($_POST['objet'])) {
         $_SESSION['error'] = "l'un des champs est vide!!";
      } else {
        $recepteur =test_input($_POST['form-control-recepteur']);
        $message =test_input($_POST['msg']);
        $objet =test_input($_POST['objet']); 
        $sql="SELECT * from professeur where email='$recepteur' ";
       $result = mysqli_query($connection, $sql);
       $row = mysqli_fetch_assoc($result);
      $id_prof=$row['num_serie'];
    $id_recepteur=$id_prof;
    $id_expediteur=$etudiant_id;
    $date=date("Y-m-d H:i:s");
    $sql="INSERT INTO message(texte,objet,id_etudiant,id_prof,datee,id_expediteur,id_recepteur) values('$message', '$objet',$etudiant_id,'$id_prof','$date','$id_expediteur', '$id_recepteur'); ";
   if( ($connection->query($sql) === TRUE)){
    $req="SELECT * FROM  message  WHERE message.id_recepteur='$id_recepteur' AND message.id_expediteur='$id_expediteur' AND message.datee='$date'";
    $res = mysqli_query($connection, $req);
    $ro = mysqli_fetch_assoc($res);
    $id_message=$ro['idMessage'];
    $status='unread';
    $reqe="INSERT INTO  notification (date_n, status,id_message) VALUES ('$date','$status',$id_message);";
    if(($connection->query($reqe) === TRUE)){
    header('Location:separationmsg.php');
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
</head>


<body>

    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">
            <!-- Start Head -->
            <?php include('head.php'); ?>
            <?php
        if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php

        }
        ?>
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
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
                                                            <a href='#myModal' data-toggle='modal'
                                                                class='btn btn-circle btn-primary text-white'>
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <span class="ml-2 font-normal text-dark">Composer</span>
                                                            <div id='myModal' class='modal fade'>
                                                                <div class='modal-dialog modal-dialog-centered '>
                                                                    <div class='modal-content'>
                                                                        <div
                                                                            class='modal-header justify-content-center  '>
                                                                            <h3 class='text-dark'>Envoyer un message
                                                                            </h3>
                                                                            <button type='button' class='close'
                                                                                data-dismiss='modal'
                                                                                aria-hidden='true'>&times;</button>
                                                                        </div>
                                                                        <div class='modal-body text-center'>
                                                                            <p>
                                                                            <div class="box text-dark">
                                                                            <div class="input-group mb-3">
<input type="text" name="ename" class="form-control select-input custom-select rounded"
  placeholder="Nom d'utilisateur" />
<div class="dropdown-menu dropdown-menu-right select-options">
  <?php
   $id_etu=$_SESSION['user_id'];
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
   $id_etu=$_SESSION['user_id'];
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
                                                                    <a href="test-msg.php" class="text-dark">
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
                                                                    <a href="sentmsg.php" class="text-dark">
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
        <script src="js/select_input.js"></script>
        <script src='js/bootstrap.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
            <script src="js/noti.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>