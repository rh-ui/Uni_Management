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
    <?php include('sidebar.php'); ?>
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
      <!--Students table-->
      <div id="add-user">
        <h1 class="p-relative">Etudiants
          <a href="addUser.php"><i class='bx bx-plus bx-rotate-90'></i></a>
        </h1>
      </div>
      <div class="projects p-20 bg-white rad-10 m-20">
        <h2 class="mt-0 mb-20">Liste des etudiants :</h2>
        <div class="responsive-table">
          <table class="fs-15 w-full">
            <thead>
              <tr>
                <td>Apogee</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>E-mail</td>
                <td>Telephone</td>
                <td>Date de Naissance</td>
                <td>Operation</td>
              </tr>
            </thead>
            <tbody>
              <?php include('listeEtu.php'); ?>
            </tbody>
          </table>
        </div>
      </div>



    </div>

    <!--Sidebar Script-->
    <script src="js/app.js"></script>
</body>

</html>