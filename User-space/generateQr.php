<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

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
</head>

<body>

  <div class="page d-flex">
    <!-------------------------------------------------Side Bar-------------------------------------------------->
    <?php include("sidebar.php"); ?>
    <!------------------------------------------------------------------------------------------------------->
    <div class="content w-full">
      <!-- Start Head -->
      <div class="head bg-white p-15 between-flex">
        <div class="search p-relative">

        </div>
        <div class="icons d-flex align-center">
          <span class="notification p-relative">
            <i class="fa-regular fa-bell fa-lg"></i>
          </span>
          <img src="imgs/face-1.png" alt="" />
        </div>
      </div>
      <!-- End Head -->
      <div id="add-user">
        <div id="add-user">
          <h1 class="p-relative">Nouveau code Qr
            <a href="#"><i class='bx bx-plus bx-rotate-90'></i></a>
          </h1>
        </div>
      </div>
      <div class="projects p-20 bg-white rad-10 m-20">

        <form action="#" method="POST">
          <input type="submit" name="submit" value="Generer le code Qr" />
        </form>
        <?php
        //inclure le fichier qui permet la connexion à la base de données
        require_once 'connection.php';
        //inclure la bibliothèque du code QR
        require_once 'phpqrcode/qrlib.php';
        if (isset($_POST['submit'])) {
          // Récupération des données de la base de données
          /* 
          session_start();
          $idProfesseur = $_SESSION['user_id'];
          */
          $result = mysqli_query($connection, "SELECT idProfesseur,idModule   FROM module "); # WHERE idProfesseur='$idProfesseur'
          // parcourir les résultats
          while ($row = mysqli_fetch_assoc($result)) {
            // générer le code QR
            $codeContents = $row['idProfesseur'];
            $codeContent_2 = $row['idModule'];
            $date_heure = date("Y-m-d H:i:s");
            $donnees_mixtes = $date_heure . " - " . $codeContents . " - " . $codeContent_2;
            $qrcode = QRcode::png($donnees_mixtes, 'Qr_imgs/' . $codeContents . '.png', QR_ECLEVEL_M, 4, 4);
            // Stocker l' id du code QR dans la base de données
            $query_res = mysqli_query($connection, "INSERT INTO codeqr (idModule) VALUES ('$codeContent_2');");
            // afficher le code QR
            if ($query_res) {
              echo "<img src='Qr_imgs/" . $codeContents . ".png'> <br>";
            }

          }
          // libérer la mémoire 
          mysqli_free_result($result);
        }
        ?>
      </div>
      <div class="projects p-20 bg-white rad-10 m-20">
        <h2 class="mt-0 mb-20">Liste des etudiants present:</h2>
      </div>
    </div>
</body>

</html>