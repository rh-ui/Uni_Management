<?php
// Start session
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$getidmodule = mysqli_query($connection, "SELECT id_module FROM module WHERE idProfesseur ='$prof_id'");
if ($getidmodule) {
  $getidmodule = mysqli_fetch_assoc($getidmodule);
  $id_module = $getidmodule['id_module'];
}
$query = "SELECT * FROM professeur,departement WHERE professeur.num_serie = '$prof_id' AND professeur.idDepartement = departement.idDepartement ;";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($result)) {
  $prof_nom = $row['nom'];
  $prof_prenom = $row['prenom'];
  $prof_email = $row['email'];
  $prof_nomDep = $row['nomDepartement'];
  $profile_img = $row['profile'];
}

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location:../login/adminLogin.php');
  die();
}
?>
<?php
function cacul_pourcentage($nombre, $total, $pourcentage)
{
  if ($total != 0 && $nombre != 0) {
    $resultat = ($nombre / $total) * $pourcentage;
    return round($resultat);
  } else {
    return 0;
  }
  // return round(0);
}

$get_total_presence = mysqli_query($connection, "SELECT COUNT(statut) FROM `presence` WHERE statut = 'Present' AND idModule = '$id_module';");
if (mysqli_num_rows($get_total_presence) > 0) {
  $total_presence = mysqli_fetch_assoc($get_total_presence);
  $get_total = (mysqli_query($connection, "SELECT COUNT(statut) FROM `presence` WHERE idModule = '$id_module';"));
  if (mysqli_num_rows($get_total) > 0) {
    $total = mysqli_fetch_assoc($get_total);
    $porcentage_p = cacul_pourcentage($total_presence['COUNT(statut)'], $total['COUNT(statut)'], 100);
  }
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
  $objet = filtr_input($_POST['objet']);
  $msg_texte = filtr_input($_POST['msg']);

  $date_heure = date("Y-m-d H:i:s");
  $apogee = mysqli_query($connection, "SELECT Apogee FROM etudiant WHERE  email ='$email';");
  if (mysqli_num_rows($apogee) > 0) {
    $apogee = mysqli_fetch_assoc($apogee);
    $apogee = (int) trim($apogee['Apogee']);
    $res = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$objet','$msg_texte','$date_heure','$apogee','$prof_id','$prof_id','$apogee')");
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
        $res1 = mysqli_query($connection, "INSERT INTO message (objet,texte,datee,id_recepteur,id_expediteur,id_prof,id_etudiant) VALUES ('$objet','$msg_texte','$date_heure','" . $insert_msg['Apogee'] . "','$prof_id','$prof_id','$apogee')");
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
  <title>Espace Professeur</title>
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
</head>

<body>
  <!-------------------------------------------------Side Bar-------------------------------------------------->
  <?php include('sidebar.php'); ?>
  <!------------------------------------------------------------------------------------------------------->
  <div class="page d-flex">
    <div class="content w-full">
      <!-- Start Head -->
      <?php include('header.php') ?>
      <!-- End Head  -->
      <h1 class="p-relative">Dashboard</h1>
      <?php
      if (isset($_SESSION['succ_status']) && $_SESSION['succ_status'] != "") {
        ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['succ_status']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['succ_status']);
      }
      if (isset($_SESSION['error_status']) && $_SESSION['error_status'] != "") {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error_status']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['error_status']);
      }
      ?>
      <div class="wrapper d-grid gap-20">
        <!-- Start Welcome Widget -->
        <div class="welcome mb-100 bg-white rad-10 txt-c-mobile block-mobile">
          <div class="intro p-20 d-flex space-between bg-white">
            <div>
              <h2 class="w-fs m-0">Bienvenue</h2>
              <p class="c-grey mt-3 fs-25 w-fs">
                <?php echo $prof_nom; ?>
              </p>
            </div>
            <img class="hide-mobile" src="imgs/welcome2.png" alt="" />
          </div>
          <img src="<?php echo $profile_img; ?>" alt="" class="avatar" />
          <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile bg-eee">
            <div class="w-fs2">
              <?php echo $prof_nom . " " . $prof_prenom; ?><span class="d-block c-grey fs-14 mt-10">
                <?php echo $prof_email; ?>
              </span>
            </div>
            <div class="w-fs2"> Departement <span class="d-block c-grey fs-14 mt-10">
                <?php echo $prof_nomDep; ?>
              </span></div>
            <div class="w-fs2">
              Numero de Serie<span class="d-block c-grey fs-14 mt-10">
                <?php echo $prof_id; ?>
              </span>
            </div>
          </div>
          <a href="settings.php" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape text-white"
            style='text-decoration:none;'>Profile</a>
        </div>
        <!-- End Welcome Widget -->

        <!-- Start Quick Draft Widget -->
        <div class="quick-draft p-20 bg-white rad-10">
          <h2 class="w-fs mt-0 mb-10">Message rapide</h2>
          <!-- <p class=" mt-0 mb-20 c-grey fs-15">Write A Draft For Your Ideas</p> -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
            <div class="input-group mb-3">
              <input type="text" name="ename" class="form-control select-input custom-select rounded"
                placeholder="Nom d'utilisateur" />
              <div class="dropdown-menu dropdown-menu-right select-options">
                <?php
                $getusers_query = mysqli_query($connection, "SELECT * FROM etudie,etudiant WHERE etudie.idModule = '$id_module' AND etudie.idEtudiant = etudiant.Apogee;");
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
              <input type="text" name="email" class="form-control select-input custom-select rounded"
                placeholder="Adresse e-mail" />
              <div class="dropdown-menu dropdown-menu-right select-options">
                <!-- <li data-value="Tous les etudiants" value="Tous les etudiants">Tous les étudiants</li> -->
                <?php
                $all_stu = mysqli_query($connection, "SELECT DISTINCT module.nomModule,module.id_module FROM etudiant,etudie,module WHERE etudie.idEtudiant=etudiant.Apogee AND module.id_module=etudie.idModule AND module.idProfesseur='$prof_id' GROUP BY module.id_module;");
                if ($all_stu) {
                  while ($all = mysqli_fetch_assoc($all_stu)) {
                    ?>
                    <li name="all" data-value="all-<?php echo $all['id_module']; ?>"
                      value="<?php echo $all['id_module']; ?>"><?php echo $all['nomModule']; ?></li>
                    <?php
                  }
                }
                ?>
                <?php
                $getusers_query = mysqli_query($connection, "SELECT * FROM etudie,etudiant WHERE etudie.idModule = '$id_module' AND etudie.idEtudiant = etudiant.Apogee;");
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
              <input type="text" name="objet" class="d-block mb-20 w-full p-10 b-none bg-eee rad-6"
                placeholder="Objet" />
            </div>
            <div class="input-group mb-3">
              <textarea name="msg" class="d-block mb-20 w-full p-10 b-none bg-eee rad-6"
                placeholder="Votre message"></textarea>
            </div>
            <input type="submit" name='send' class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape"
              value="Envoyer" />
          </form>
        </div>
        <!-- End Quick Draft Widget -->
        <!-- Start Statistics Widget -->
        <div class="targets p-20 bg-white rad-10">
          <h2 class="w-fs mt-0 mb-10">Statistique </h2>
          <div class="prog-container">
            <div class="circular-progress">
              <span class="progress-value">0%</span>
            </div>
            <span class="prog-text">pourcentage de presence</span>
          </div>
        </div>
        <script>
          let circularProgress = document.querySelector(".circular-progress");
          progressValue = document.querySelector(".progress-value");

          let progressStartValue = 0,
            progressEndValue = <?php echo $porcentage_p; ?>,
            speed = 100;

          if (progressEndValue > 0) {
            let progress = setInterval(() => {
              progressStartValue++;

              progressValue.textContent = `${progressStartValue}%`;
              circularProgress.style.background = `conic-gradient(rgb(17, 32, 146) ${progressStartValue * 3.6}deg, #f5f4fc 0deg)`;

              if (progressStartValue === progressEndValue) {
                clearInterval(progress);
              }
            }, speed);
          }
        </script>
        <!-- End Statistics Widget -->
        <!-- Start Ticket Widget   -->
        <!-- <div class="tickets p-20 bg-white rad-10">
          <h2 class="w-fs mt-0 mb-10">Tickets Statistics</h2>
          <p class="mt-0 mb-20 c-grey fs-15">Everything About Support Tickets</p>
          <div class="d-flex txt-c gap-20 f-wrap">
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">2500</span>
              Total
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">500</span>
              Pending
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">1900</span>
              Closed
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-rectangle-xmark fa-2x mb-10 c-red"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">100</span>
              Deleted
            </div>
          </div>
        </div> -->
        <!-- End Ticket Widget -->
        <!-- Start Calendar Widget -->
        <div class="latest-news p-20 bg-white rad-10 txt-c-mobile">
          <h2 class="w-fs mt-0 mb-20">Calendrier</h2>
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
        <!-- End Calendar Widget -->
        <!-- Start Latest Uploads Widget -->
        <div class="latest-uploads p-20 bg-white rad-10">
          <h2 class="w-fs mb-20 mt-15">Fichiers recents</h2>
          <?php
          $getfiles = mysqli_query($connection, "SELECT * FROM files,module WHERE module.id_module=files.idModule AND module.idProfesseur='$prof_id' ORDER BY date_p DESC LIMIT 7 OFFSET 0;");
          if ($getfiles) {
            while ($files = mysqli_fetch_assoc($getfiles)) {
              $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
              ?>
              <ul class="mb-10 mt-20">
                <li class="between-flex pb-10 mb-10">
                  <div class="d-flex align-center">
                    <?php
                    if (in_array($extension, ['zip'])) {
                      ?>
                      <img class="mr-10" src="imgs/zip.svg" alt="" />
                      <?php
                    } elseif (in_array($extension, ['pdf'])) {
                      ?>
                      <img class="mr-10" src="imgs/pdf.svg" alt="" />
                      <?php
                    } elseif (in_array($extension, ['png']) || in_array($extension, ['jpge']) || in_array($extension, ['jpg'])) {
                      ?>
                      <img class="mr-10" src="imgs/png.svg" alt="" />
                      <?php
                    }
                    ?>
                    <div>
                      <span class="d-block">
                        <?php echo $files['name']; ?>
                      </span>
                      <!-- <span class="fs-15 c-grey">Elzero</span> -->
                    </div>
                  </div>
                  <div class="bg-eee btn-shape fs-13">
                    <?php echo $files['size'] / 1000 . " Kbs"; ?>
                  </div>
                </li>
              </ul>
              <?php
            }
          }
          ?>
        </div>
        <!-- End Latest Uploads Widget -->
        <!-- Start Last Project Progress Widget -->
        <!-- <div class="last-project p-20 bg-white rad-10 ">
          <h2 class="w-fs mt-0 mb-20">Last Project Progress</h2>
          <ul class="m-0">
            <li class="mt-25 d-flex align-center done">Got The Project</li>
            <li class="mt-25 d-flex align-center done">Started The Project</li>
            <li class="mt-25 d-flex align-center done">The Project About To Finish</li>
            <li class="mt-25 d-flex align-center current">Test The Project</li>
            <li class="mt-25 d-flex align-center">Finish The Project & Get Money</li>
          </ul>
          <img class="launch-icon hide-mobile" src="imgs/project.png" alt="" />
        </div> -->
        <!-- End Last Project Progress Widget -->
        <!-- Start Reminders Widget -->
        <!-- <div class="reminders p-20 bg-white rad-10">
          <h2 class="w-fs mt-0 mb-25">Reminders</h2>
          <ul class="m-0">
            <li class="d-flex align-center mt-15">
              <span class="key bg-blue mr-15 d-block rad-half"></span>
              <div class="pl-15 blue">
                <p class="fs-14 fw-bold mt-0 mb-5">Check My Tasks List</p>
                <span class="fs-13 c-grey">28/09/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-green mr-15 d-block rad-half"></span>
              <div class="pl-15 green">
                <p class="fs-14 fw-bold mt-0 mb-5">Check My Projects</p>
                <span class="fs-13 c-grey">26/10/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-orange mr-15 d-block rad-half"></span>
              <div class="pl-15 orange">
                <p class="fs-14 fw-bold mt-0 mb-5">Call All My Clients</p>
                <span class="fs-13 c-grey">05/11/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-red mr-15 d-block rad-half"></span>
              <div class="pl-15 red">
                <p class="fs-14 fw-bold mt-0 mb-5">Finish The Development Workshop</p>
                <span class="fs-13 c-grey">20/12/2022 - 12:00am</span>
              </div>
            </li>
          </ul>
        </div> -->
        <!-- End Reminders Widget -->
      </div>
    </div>
  </div>

  <!--Sidebar Script-->
  <script src="js/app.js"></script>
  <script src="js/calendar.js"></script>
  <script src="js/progress.js"></script>
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