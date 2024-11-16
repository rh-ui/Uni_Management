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
    <div class="content w-full">

      <!-- Start Head -->
      <?php include('head.php'); ?>

      <!-- End Head -->

      <!--Students table-->
      <div id="add-user">
        <h1 class="p-relative">fichiers</h1>
      </div>
      <div class="projects p-20 bg-white rad-10 m-20">
        <div class="responsive-table">
          <table class="fs-15 w-full">
            <thead>
              <tr>
                <td>
                  <div class=" txt-c">
                    modules
                  </div>
                </td>
            </thead>
            <!-- <tbody> -->
            <?php

            $id_et = $_SESSION['user_id'];
            if (!$connection) {
              die('error' . mysqli_connect_error());
            } else {
              if (isset($_GET['id_semester'])) {
                $semester = $_GET['id_semester'];
                $sql = "SELECT * from module,module_filiere WHERE module_filiere.idModule=module.id_module and module_filiere.semester='$semester';";
                $resultat = mysqli_query($connection, $sql);
              }
            }
            ?>
            <?php while ($modules = mysqli_fetch_assoc($resultat)) { ?>

              <tr>
                <td>

                  <div class="txt-c">
                    <a href="module.php?id_module=<?php echo $modules['id_module'] ?> " class="herf"><?php echo $modules['nomModule'] ?></a>
                  </div>
                </td>
              </tr>
            <?php }
            ; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--Sidebar Script-->
    <script src="js/app.js"></script>
    <script src="js/noti.js"></script>

</body>


</html>