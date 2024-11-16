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
$id = $_SESSION['user_id'];
$sql = "SELECT * from etudiant where Apogee=$id ";
$resultat = mysqli_query($connection, $sql);
$etudiant = mysqli_fetch_assoc($resultat);
?>
<?php

$etudiant_id = $_SESSION['user_id'];
if (isset($_POST['submit'])) {
  if (empty($_POST['form-control-recepteur']) || empty($_POST['msg']) || empty($_POST['objet'])) {
    $_SESSION['error'] = "l'un des champs est vide!!";
  } else {
    $recepteur = test_input($_POST['form-control-recepteur']);
    $message = test_input($_POST['msg']);
    $objet = test_input($_POST['objet']);
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

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location:../login/userLogin.php');
}
?>
<?php
$id_etudiant = $_SESSION['user_id'];
$sql = "SELECT count(*) as nb from presence WHERE presence.idEtudiant=$id_etudiant and presence.statut='present'";
$resultat = mysqli_fetch_assoc(mysqli_query($connection, $sql));

$req = "SELECT count(*) as diviseur from presence WHERE presence.idEtudiant=$id_etudiant";
$div = mysqli_fetch_assoc(mysqli_query($connection, $req));
$divide = $div['diviseur'];
$totale = $resultat['nb'];
?>
<!DOCTYPE html>
<html lang="en">

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


  <!-------------------------------------------------Side Bar-------------------------------------------------->
  <?php
  include('sidebar.php'); ?>
  <!------------------------------------------------------------------------------------------------------->
  <div class="page d-flex">
    <div class="content w-full">
      <!-- Start Head -->

      <!-- Start Head -->
      <?php include('head.php') ?>
      <!--start error empty-->
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
      <!--end error empty-->
      <!-- End Head -->
      <h1 class="p-relative">Dashboard</h1>
      <div class="wrapper d-grid gap-20">
        <!-- Start Welcome Widget -->
        <div class="welcome bg-white rad-10 txt-c-mobile block-mobile ">
          <div class="intro p-20 d-flex space-between bg-white  mb-5">
            <div class='mb-5'>
              <h2 class="m-0">Bienvenue</h2>
              <p class="c-grey mt-5">
                <?php echo $etudiant['nom'] ?>
              </p>
            </div>
            <img class="hide-mobile" src="imgs/welcome2.png" alt="" />
          </div>
          <img src="<?php echo $etudiant['profile'] ?>" alt="" class="avatar" />
          <div class="body txt-c d-flex p-20 mt-20 mb-5 block-mobile mb-5 bg-eee">
            <div>
              <?php echo $etudiant['nom'] . " " . $etudiant['prenom'] ?><span
                class="d-block c-grey fs-14 mt-10">Etudiant</span>
            </div>
            <div>
              <?php echo $etudiant['Apogee'] ?><span class="d-block c-grey fs-14 mt-10">Apogee</span>
            </div>
            <div>
              <?php echo $etudiant['cin'] ?><span class="d-block c-grey fs-14 mt-10">CIN</span>
            </div>
          </div>
          <a href="profile.php" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape"
            style="text-decoration:none;">Profile</a>
        </div>
        <!-- End Welcome Widget -->
        <!-- Start Quick Draft Widget -->
        <div class="quick-draft p-20 bg-white rad-10">
          <h2 class="mt-0 mb-10">Message Rapide</h2>
          <form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                    <li data-value="<?php echo $users['prenom'] . " " . $users['nom']; ?>"
                      value="<?php echo $users['prenom'] . " " . $users['nom']; ?>"><?php echo $users['prenom'] . " " . $users['nom']; ?></li>
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
            <input class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" id="objet" placeholder="Objet" name="objet" />
            <textarea class="d-block mb-5 w-full p-10 b-none bg-eee rad-6" name="msg" id="msg"
              placeholder="Tapez votre message ici ..."></textarea>
            <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" id="send"
              name='submit' />
          </form>
        </div>
        <!-- End Quick Draft Widget -->
        <!-- Start Statistics Widget -->
        <?php
        if ($totale != 0) {
          $nbr = ($totale / $divide) * 100;
          ?>
          <div class="targets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Statistique de presence</h2>
            <div class="container11">
              <div class="circular-progress11">
                <span class="progress-value11">
                  <?php echo $nbr; ?>
                </span>
              </div>

              <span class=" text ">Pourcentage de presence</span>
            </div>
          </div>
        <?php } else {
          $nbr = 0;
          ?>
          <div class="targets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Statistique de presence</h2>
            <div class="container11">
              <div class="circular-progress11">
                <span class="progress-value11">
                  <?php echo $nbr; ?>%
                </span>
              </div>

              <span class=" text ">Pourcentage de presence</span>
            </div>
          </div>
        <?php } ?>


        <!-- End Statistics Widget -->
        <!-- Start Calendar Widget -->
        <div class="latest-news p-20 bg-white rad-10 txt-c-mobile">
          <h2 class="mt-0 mb-20">Calendrier</h2>
          <div class="light">
            <div class="calendar">
              <div class="calendar-header">
                <span class="month-picker" id="month-picker">April</span>
                <div class="year-picker">
                  <span class="year-change" id="prev-year">
                    <pre><</pre>
                  </span>
                  <span id="year">2022</span>
                  <span class="year-change" id="next-year">
                    <pre>></pre>
                  </span>
                </div>
              </div>
              <div class="calendar-body">
                <div class="calendar-week-day">
                  <div>Sun</div>
                  <div>Mon</div>
                  <div>Tue</div>
                  <div>Wed</div>
                  <div>Thu</div>
                  <div>Fri</div>
                  <div>Sat</div>
                </div>
                <div class="calendar-days"></div>
              </div>

              <div class="month-list"></div>
            </div>
          </div>
        </div>
        <!-- End calendar -->
        <!-- Start Latest Uploads Widget -->
        <div class="latest-uploads p-20 bg-white rad-10">
          <h2 class="mt-0 mb-20">Derniers Fichiers</h2>
          <ul class="m-0">
            <?php
            $sql = "SELECT * FROM files ORDER BY date_p LIMIT 5";
            $result = mysqli_query($connection, $sql);
            while ($file = mysqli_fetch_assoc($result)) {
              $id = $file['id'];
              $req = "SELECT * FROM files,professeur,module WHERE module.idProfesseur=professeur.num_serie AND module.id_module=files.idModule   AND files.id=$id";
              $rel = mysqli_query($connection, $req);
              $prof = mysqli_fetch_assoc($rel);

              ?>
              <li class="between-flex pb-10 mb-10">
                <div class="d-flex align-center">
                  <?php
                  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                  if (in_array($extension, ['png'])) {
                    echo "<img class='mt-15 mb-15 item-c' src='imgs/png.svg'>";
                  }
                  if (in_array($extension, ['pdf'])) {

                    echo "<img class='mt-15 mb-15 item-c' src='imgs/pdf.svg'>";
                  }
                  if (in_array($extension, ['zip'])) {

                    echo "<img class='mt-15 mb-15 item-c' src='imgs/zip.svg'>";
                  }
                  if (in_array($extension, ['jpg'])) {

                    echo "<img class='mt-15 mb-15 item-c' src='imgs/png.svg'>";
                  }

                  ?>

                  <div>
                    <span class="d-block">
                      <?php echo $file['name'] ?>
                    </span>
                    <span class="fs-15 c-grey">
                      <?php echo $prof['nom'] ?>
                    </span>
                  </div>
                </div>
                <div class=" fs-13"><a href="download.php?id_file=<?php echo $file['id'] ?> "
                    class="btn btn-circle btn-primary text-white" role="button">Telecharger
                  </a></div>
              </li>
            <?php } ?>
          </ul>
        </div>
        <!-- End Latest Uploads Widget -->
        <!--Sidebar Script-->
        <!-- JQUERY -->
        <script src="js/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
        <script src="js/calendar.js"></script>
        <script src="js/prog.js"></script>
        <script src="js/noti.js"></script>
        <script src='js/popper.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
        <script src="js/select_input.js"></script>
        <script>
          $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
          })
        </script>
</body>

</html>