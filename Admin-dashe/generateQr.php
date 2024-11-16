<?php

//inclure le fichier qui permet la connexion à la base de données
require_once 'connection.php';
session_start();
$prof_id = $_SESSION['user_id'];
$idModule = $_SESSION['id_module'];

?>
<?php
$test_existance = mysqli_query($connection, "SELECT * FROM temp_presence");
if (mysqli_num_rows($test_existance) == 0) { //si la table est vide 
  $query_res = mysqli_query($connection, "SELECT * FROM etudie WHERE idModule = '$idModule'");
  if ($query_res) {
    while ($query_row = mysqli_fetch_assoc($query_res)) {
      $apogee = $query_row['idEtudiant'];
      $res = mysqli_query($connection, "INSERT INTO temp_presence (idEtudiant,idModule) VALUES ('$apogee','$idModule')");
      if ($res) {
        // echo $query_row['idEtudiant'] . 'inserted into temp_presence';
      }
    }
  }
} else { //sinon
  if (mysqli_num_rows(mysqli_query($connection, "SHOW TABLES LIKE 'u_temp_presence';")) > 0) {
    $sql = "SELECT * FROM u_temp_presence";
    $result = mysqli_query($connection, $sql);
    if ($result) {
      $u_row = mysqli_fetch_assoc($result);
      $apogee = $u_row['idEtudiant'];
      $idModule = $u_row['idModule'];
      $statut = $u_row['statut'];
      $date = $u_row['date_presence'];
      $sql = "UPDATE temp_presence SET statut = '$statut' WHERE idEtudiant = '$apogee' AND idModule = '$idModule';";
      $res = mysqli_query($connection, $sql);
      if ($res) {
        mysqli_query($connection, "DROP TABLE u_temp_presence");
      }
    }
  }
}
?>

<?php
if (isset($_POST['drop'])) {
  $getLastSeance = mysqli_query($connection, "SELECT id_seance FROM presence WHERE idModule='$idModule' ORDER BY id_seance DESC LIMIT 1");
  if (mysqli_num_rows($getLastSeance) > 0) {
    $seance = mysqli_fetch_assoc($getLastSeance);
    $seance = $seance['id_seance'] + 1;
  } else {
    $seance = 1;
  }
  foreach ($_POST as $key => $value) {
    if (strpos($key, 'statut_') !== false) {
      $apogee = explode("_", $key)[1];
      $statut = mysqli_real_escape_string($connection, $value);
      $sql = "UPDATE temp_presence SET statut = '$statut' WHERE idEtudiant = '$apogee' AND idModule = '$idModule'";
      $res = mysqli_query($connection, $sql);
    }
  }
  foreach ($_POST as $key => $value) {
    if (strpos($key, 'statut2_') !== false) {
      $apogee = explode("_", $key)[1];
      $statut = mysqli_real_escape_string($connection, $value);
      $sql = "UPDATE temp_presence SET statut = '$statut' WHERE idEtudiant = '$apogee' AND idModule = '$idModule'";
      $res = mysqli_query($connection, $sql);
    }
  }
  $sql = "SELECT * FROM temp_presence";
  $result = mysqli_query($connection, $sql);
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $apogee = $row['idEtudiant'];
      $idModule = $row['idModule'];
      $statut = $row['statut'];
      $date = date("Y-m-d H:i:s");
      $sql = "INSERT INTO presence(idEtudiant,idModule,statut,date_p,id_seance) VALUES('$apogee','$idModule','$statut','$date','$seance')";
      $resr = mysqli_query($connection, $sql);
    }
  }
  mysqli_query($connection, "DELETE FROM temp_presence;");
  header('Location:statistics.php');
  die();
}

if (isset($_POST['cancel'])) {
  mysqli_query($connection, "DELETE FROM temp_presence;");
  header('Location:qr_choose_semester.php');
  die();
}
?>

<?php
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
  <title>Présence</title>
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

  <div class="page d-flex">
    <!-------------------------------------------------Side Bar-------------------------------------------------->
    <?php include("sidebar.php"); ?>
    <!------------------------------------------------------------------------------------------------------->
    <div class="content w-full">
      <!-- Start Head -->
      <?php include('header.php'); ?>
      <!-- End Head -->
      <div class="projects bg-white d-grid m-20 gap-20 p-20 rad-10">
        <div class="d-flex" id="add-qr">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="myForm">
            <h1 class="p-relative">Nouveau code Qr
              <button type="submit" name="btn" class="" id="">
                <i class='bx bx-plus bx-rotate-90'></i>
              </button>
            </h1>
          </form>
        </div>
        <?php
        //inclure la bibliothèque du code QR
        require_once 'phpqrcode/qrlib.php';
        if (isset($_POST['btn'])) {
          // Récupération des données de la base de données
          $result = mysqli_query($connection, "SELECT * FROM professeur,module,module_filiere,filiere WHERE module.id_module = '$idModule' AND professeur.num_serie='$prof_id' AND professeur.num_serie = module.idProfesseur AND module_filiere.idModule = module.id_module AND filiere.idFiliere = module_filiere.idFiliere;");
          // parcourir les résultats
          while ($row = mysqli_fetch_assoc($result)) {
            // générer le code QR
            $codeContents = $prof_id;
            $codeContent_2 = $row['id_module'];
            $codeContent_3 = $row['idFiliere'];
            $date_heure = date("Y-m-d H:i:s");
            $donnees_mixtes = $codeContent_2 . ";" . $codeContents . $date_heure . ";" . $codeContent_3;
            $qrcode = QRcode::png($donnees_mixtes, 'Qr_imgs/' . $codeContents . '.png', QR_ECLEVEL_M, 4, 4);
            // Stocker l' id du code QR dans la base de données
            $query_res = mysqli_query($connection, "INSERT INTO codeqr (idModule) VALUES ('$codeContent_2');");
            // afficher le code QR
            ?>
            <div class='row'>
              <div class='column'>
                <img src='Qr_imgs/<?php echo $codeContents; ?>.png'>
              </div>
              <div class='column text-center mt-0' id='column'>
                <div class="card border-0 mt-0" style="width: 29rem;">
                  <div class="text-center p-40">
                    <h5 class="card-title">Contenu du code </h5>
                    <p class="card-text ">
                    <p>
                      <span class='fw-bold'> Professeur :</span>
                      <?php echo $row['nom'] . " " . $row['prenom']; ?>
                    </p>
                    <p>
                      <span class='fw-bold'>Module : </span>
                      <?php echo $row['nomModule'] ?>
                    </p>
                    <p>
                      <span class='fw-bold'> Filiere : </span>
                      <?php echo $row['nomFiliere'] ?>
                    </p>
                    <p>
                      <span class='fw-bold'> Date Actuelle : </span>
                      <?php echo $date_heure ?>
                    </p>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <?php
            // echo "<img src='Qr_imgs/" . $codeContents . ".png'>";
          }
        }
        ?>
      </div>
      <div class="projects p-20  bg-white rad-10 m-20" id="tableau">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
          <h2 class="wr-fs mt-0 mb-20">
            Liste des étudiants présents
          </h2>
          <div class="responsive-table table">
            <table class="fs-15 w-full">
              <thead>
                <tr>
                  <td>
                    <div class="between-flex">
                      Apogee
                    </div>
                  </td>
                  <td>
                    <div class="between-flex">
                      Nom
                    </div>
                  </td>
                  <td>
                    <div class="between-flex">
                      Prenom
                    </div>
                  </td>
                  <td>
                    <div class="between-flex">
                      Groupe
                    </div>
                  </td>
                  <td>Statut</td>
                </tr>
              </thead>
              <tbody>
                <?php
                $presult = mysqli_query($connection, "SELECT * FROM etudie,etudiant,temp_presence WHERE etudie.idEtudiant=etudiant.Apogee AND temp_presence.idEtudiant=etudie.idEtudiant AND etudie.idModule = '$idModule' ;");
                if ($presult) {
                  while ($prow = mysqli_fetch_assoc($presult)) {
                    ?>
                    <tr>
                      <td>
                        <?php echo $prow['idEtudiant']; ?>
                      </td>
                      <td>
                        <?php echo $prow['nom']; ?>
                      </td>
                      <td>
                        <?php echo $prow['prenom']; ?>
                      </td>
                      <td>
                        <?php echo $prow['id_groupe']; ?>
                      </td>
                      <td class="col-md-3">
                        <input type="text" name="statut_<?php echo $prow['idEtudiant'] ?>"
                          id="statut_<?php echo $prow['idEtudiant'] ?>" class="form-control bg-white text-center border-0"
                          value="<?php echo $prow['statut'] ?>" readonly>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  ?>
                  <img src="imgs\No data.gif" alt="">
                  <?php
                } ?>
              </tbody>
            </table>
            <div class='pt-20 pl-100'>
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <button type="submit" class="btn btn-secondary" name="cancel">
                  Ignorer
                </button>
              </form>
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#val" id="stop">
                Valider
              </button>
              <!-- Modal -->
              <div class="modal fade" id="val" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation des données</h1> -->
                      <div class="head bg-white p-15 between-flex">
                        <div class="col-md-12">
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="recherche" onkeyup="fltrr()"
                              id="maRecherche2">
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-1">
                        <div class="responsive-table table ">
                          <table class="fs-15 w-full">
                            <thead>
                              <tr>
                                <td>Nom</td>
                                <td>Prenom</td>
                                <td>Statut</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $getAbsent = mysqli_query($connection, "SELECT * FROM temp_presence,etudiant WHERE temp_presence.idEtudiant = etudiant.Apogee AND temp_presence.statut ='Absent'");
                              if ($getAbsent) {
                                while ($absent = mysqli_fetch_assoc($getAbsent)) {
                                  ?>
                                  <tr id="tr">
                                    <td>
                                      <?php echo $absent['nom']; ?>
                                    </td>
                                    <td>
                                      <?php echo $absent['prenom']; ?>
                                    </td>
                                    <td>
                                      <select name="statut2_<?php echo $absent['Apogee'] ?>"
                                        id="statut2_<?php echo $absent['Apogee'] ?>" class="form-select" required>
                                        <option value="Absent">Absent</option>
                                        <option value="Present">Present</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="go">Ignorer</button>
                      <button type="submit" name="drop" class="btn btn-primary" required>Valider</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
</body>
<!--Sidebar Script-->
<script src="js/app.js"></script>
<!-- JQUERY -->
<script src="js/jquery.min.js"></script>

<!-- Start Script de confirmationde la supression -->
<!-- End Script de confirmationde la supression -->
<!-- <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script> -->
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
  // Drapeau indiquant si l'actualisation automatique est en cours
  var actualisationEnCours = false;

  // ID du timer pour l'actualisation automatique
  var timerID;

  // Fonction pour actualiser la page
  function actualiserPage() {
    // window.location.href = '#tableau';
    location.reload();
  }

  // Démarrer l'actualisation automatique
  function demarrerActualisation() {
    if (!actualisationEnCours) {
      actualisationEnCours = true;
      timerID = setInterval(actualiserPage, 9000);
    }
  }

  // Arrêter l'actualisation automatique
  function arreterActualisation() {
    clearInterval(timerID);
    actualisationEnCours = false;
  }


  // Événement de clic sur le bouton "Stop"
  document.getElementById("stop").addEventListener("click", function () {
    arreterActualisation();
  });
  demarrerActualisation();
</script>
<!-- Script de recherche dans le modal -->
<script>
  function fltrr() {
    const fltr = document.getElementById('maRecherche2');
    const row = document.querySelectorAll('#tr');

    fltr.addEventListener('input', function (event) {
      const searchValue = fltr.value.toLowerCase();

      row.forEach((row, i) => {
        const rwData = row.textContent.toLowerCase();

        if (rwData.indexOf(searchValue) === -1) {
          row.style.display = "none";
        } else {
          row.style.display = "";
          row.style.setProperty('--delay', i / 25 + 's');
        }
      });
    });
  }
</script>

</html>

<?php

?>