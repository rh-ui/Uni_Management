<?php
include('connection.php');
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
        <div class="content w-full" >

            <!-- Start Head -->
            <?php include('head.php') ?>       
            <!-- End Head -->
            <!--Students table-->
            <div  class="container-lg p-20 pl-0 pr-0" >
            
            
<div class="w-full bg-white rad-6">
    <!-- Content Place Here -->
    <div class="email-app card">
            <div class="email-desc-wrapper w-full p-40">

              <?php 
               $etudiant_id = $_SESSION['user_id'];
               if (isset($_GET['id_message'])) {
                $id = $_GET['id_message'];
                $req="UPDATE notification SET status='read' WHERE id_message=$id";
                $rel= mysqli_query($connection,$req);
                $reqe="SELECT * FROM message where idMessage=$id ";
                $res = mysqli_query($connection,$reqe);
                $pow=mysqli_fetch_assoc($res);
                if($pow['id_recepteur']==$etudiant_id){
                $sql="SELECT * from message,professeur where message.id_expediteur=professeur.num_serie AND idMessage=$id;";
                $result = mysqli_query($connection,$sql);
                }else{
                    $sql="SELECT * from message,etudiant where message.id_etudiant=etudiant.Apogee AND idMessage=$id;";
                    $result = mysqli_query($connection,$sql);  
                }
               }
               while ($message = mysqli_fetch_assoc($result)) {
              ?>
                <div class="email-header  w-full pb-20">
                <div class="email-date fs-15 c-grey mb-5"><?php echo $message['datee']?></div>
                <div class="fw-bold fs-30 w-fs mb-5  text-center text-black"><?php echo $message['objet']?></div>
                <p class="c-grey"><span  class="c-black fw-bold fs-20 block-mobile">From:</span  ><?php echo $message['email']?> </p>
            </div>
            <div class="email-body mb-20">
                <p><?php echo $message['nom']?>,</p>
                <p>
                <?php echo $message['texte']?>. 
                </p>
                
                <p>
                   merci &amp; cordialement <br />
                  
                </p>
            </div>
           
               
            
            <div class="email-action m-20">
              <div class="email-action text-center mt-100">  <?php if($pow['id_recepteur']==$etudiant_id){ ?> <button class="btn btn-primary" href='#myModal' data-toggle='modal'>Repondre <i class="fa fa-reply"></i></button> <?php } ?>
                               

                                           <li class="list-inline-item text-info mr-3">
                                                        <form action='test-msg.php' method='POST'>
                                                           
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
                                                                                <h3 style="color:black;">Envoyer un message</h3>
                                                                                <div class="name">
                                                                                    <div class="input-group mb-3">
                                                                                        <select name="ename"
                                                                                            class="custom-select"
                                                                                            required>
                                                                                            <option selected>---
                                                                                            </option>
                                                                                            <?php
                                                                                            
                                                                                            
                                                                                            $res = mysqli_query($connection, "SELECT * from message,professeur where message.id_expediteur=professeur.num_serie AND idMessage=$id;");
                                                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                                                echo "<option selected >" . $row['nom'] . $row['prenom'] . "</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="email">
                                                                                    <div class="input-group mb-3">
                                                                                       <select name="form-control-recepteur" class="custom-select" required>
                                                                                             <option selected>Addres  E-mail</option>
                                                                                                       <?php
                                                                                                          $res = mysqli_query($connection, "SELECT * from message,professeur where message.id_expediteur=professeur.num_serie AND idMessage=$id;");
                                                                                                          while ($row = mysqli_fetch_assoc($res)) {
                                                                                                          echo "<option selected>" . $row['email'] . "</option>";
                                                                                                                                                 }
                                                                                                        ?>
                                                                                        </select>
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
                                                        <a class="btn btn-danger" href="test-msg.php?id_message=<?php echo $message['idMessage']?>"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                       <line x1="10" y1="11" x2="10" y2="17"></line>
                                                       <line x1="14" y1="11" x2="14" y2="17"></line>
                                                       </svg> supprimer</a></div>
                                </div>
        <?php }?>
           </div>
     </div>  
   </div>
</div>
        <!--Sidebar Script-->
<script src="js/app.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='js/bootstrap.min.js'></script>
<script src='js/popper.min.js'></script>
<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
<script src="js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
<script src="js/calendar.js"></script>
<script src="js/prog.js"></script>
<script src="js/noti.js"></script>
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="js/noti.js"></script>
</body>


</html>