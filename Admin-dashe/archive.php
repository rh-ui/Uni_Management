<?php
session_start();
$prof_id = $_SESSION['user_id'];
$id_Module = $_SESSION['id_module'];
$_SESSION['id_module'] = $id_Module;
include('connection.php');
if (isset($_POST['groupe-btn'])) {
  $_SESSION['groupe'] = $_POST['groupe-btn'];
  header('Location:H_listeEtudiant.php');
  die();
}

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
  <title>Historique</title>
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
      <div class="archive d-grid m-20 gap-20 p-10 rad-10">
        <?php
        $res = mysqli_query($connection, "SELECT DISTINCT etudiant.id_groupe FROM etudie,etudiant WHERE etudie.idEtudiant=etudiant.Apogee AND etudie.idModule='$id_Module';");
        if ($res) {
          while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <div class="card" style="width: 18rem;">
              <img src="imgs\team.jpg" class="card-img-top" alt="groupe image">
              <div class="card-body center-flex">
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
                <form action="#" method="post">
                  <button type="submit" name='groupe-btn' class="btn btn-outline-info"
                    value="<?php echo $row['id_groupe']; ?>">Groupe
                    <?php echo $row['id_groupe']; ?>
                  </button>
                </form>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!--Sidebar Script-->
  <script src="js/app.js"></script>
  <!-- JQUERY -->
  <script src="js/jquery.min.js"></script>
  <!-- Start Script de confirmationde la supression -->

  <script>
    $(document).ready(function () {
      $('.alertbox').click(function () {
        var apogee = $(this).data('apogee');
        $('#error-' + apogee).html('');
        $('#myModal-' + apogee).modal('show');
      });
    });
  </script>
  <!-- End Script de confirmationde la supression -->
  <!-- <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script> -->
  <script src='js/popper.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>