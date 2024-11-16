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
  <link rel="stylesheet" href="scanner.css" />

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
      <!--scanner table-->
      <div id="add-user">
        <h1 class="p-relative">SCANNER
        </h1>
        <?php
        if (isset($_SESSION['succ']) && $_SESSION['succ'] != "") {
          ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['succ']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php
          unset($_SESSION['succ']);
        }
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
      </div>
      <div class="projects p-20 bg-white rad-10 m-20">
        <h2 class="mt-0 mb-20"></h2>
        <div class="responsive-table">
          <div class="scanner-container">
            <div class="scanner">
              <div class="scanner-bar"></div>
              <video id="video" width="300" height="200" autoplay class=video></video>
              <canvas id="canvas" width="300" height="300" style="display:none"></canvas>
            </div>
          </div>

          <form action="insert.php" method="post">
            <input type="text" name="text" id="text" placeholder="Qr code">
          </form>
        </div>
      </div>



    </div>

    <script src="instascan.min.js"></script>
    <!--Sidebar Script-->
    <script src="js/app.js"></script>
    <!--scanner script-->
    <script>
      let scanner = new Instascan.Scanner({ video: document.getElementById('video') });
      scanner.addListener('scan', function (content) {
        // alert('Scanned: ' + content);
        document.getElementById('text').value = content;
        document.forms[0].submit();
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });

    </script>
    <!--for scanner-->
    <script src="js/noti.js"></script>

</body>

</html>