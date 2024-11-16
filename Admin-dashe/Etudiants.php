<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$id_Module = $_SESSION['id_module'];

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
  <title>Liste des etudiants</title>
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
      <div class="projects p-20 bg-white rad-10 m-20">
        <h2 class="w-fs mt-0 mb-20">Liste des etudiants :
          <div class="d-flex flex-row-reverse bd-highlight">
            <div class="p-1 bd-highlight">
              <a href="#" class='btn btn-link btn-lg' data-toggle="modal" data-target="#exampleModal">
                <i class='bx bxs-file-import'></i>
                <span class="ml-2 default font-weight-normal text-dark w-fs">Importer</span>
              </a>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form enctype="multipart/form-data" action="import_csv.php" method="post">
                      <div class="modal-body">
                        <div class="col-mb-3 center-flex">
                          <span class="">
                            <input class="form-control" id="formFilelg" type="file" name="file" accept=".csv" required>
                          </span>
                        </div>
                        <p class="fs-6 text-center fw-lighter p-20">le fichier doit être sous
                          format csv <span style='color:red;'>*</span></p>
                        <p class="fs-6 text-center fw-lighter">
                          <a href="import_example.php?import_example">voici un exemple à télécharger</a>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" id="submit" name="import" value="<?php echo $id_Module; ?>"
                          class="btn btn-primary">Importer</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="p-1 bd-highlight">
            <a href="export_pdf.php?id=<?php echo $id_Module; ?>" class='btn btn-link btn-lg'>
              <i class='bx bx-export'></i>
              <span class="ml-2 default font-weight-normal text-dark w-fs">Exporter</span>
            </a>
          </div>
          <div class="p-1 bd-highlight">
            <a href="#" class='btn btn-link btn-lg' data-toggle="modal" data-target="#add2">
              <i class='bx bx-add-to-queue'></i>
              <span class="ml-2 default font-weight-normal text-dark w-fs">Ajouter</span>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="add2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau étudiant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class='needs-validation' action='addUser.php' method='post' novalidate>
                    <div class="modal-body">
                      <p>
                      <section class=''>
                        <div class=''>
                          <div class='form-row'>
                            <div class='col-md-6 mb-3'>
                              <input type='text' name='apogee' id='apogee' class='form-control'
                                placeholder='Numero Apogee' required>
                            </div>
                            <div class='col-md-6 mb-3'>
                              <div class='input-group'>
                                <input type='text' class='form-control' id='cin' name='cin' placeholder='CIN' required>
                              </div>
                            </div>
                          </div>
                          <div class='form-row'>
                            <div class='col-md-6 mb-3'>
                              <div class='input-group'>
                                <input type='text' name='name' id='name' class='form-control' placeholder='Nom'
                                  aria-describedby='inputGroupPrepend' required>
                              </div>
                            </div>
                            <div class='col-md-6 mb-3'>
                              <div class='input-group'>
                                <input type='text' name='prenom' id='prenom' class='form-control' name='prenom'
                                  id='prenom' placeholder='Prenom' aria-describedby='inputGroupPrepend' required>
                              </div>
                            </div>
                            <div class='col-md-12 mb-3'>
                              <div class='input-group'>
                                <input type='email' name='email' id='email' placeholder='Votre adress email'
                                  class='form-control' aria-describedby='inputGroupPrepend' required>
                              </div>
                            </div>
                            <div class='col-md-6 mb-3'>
                              <input type='number' name='phoneNumber' id='phoneNumber' placeholder='Numero du telephone'
                                class='form-control' required />
                            </div>
                            <div class='col-md-6 mb-3'>
                              <select name="genre" class="form-select text-muted" required>
                                <option value="femme">Femme</option>
                                <option value="homme">homme</option>
                              </select>
                            </div>
                          </div>
                          <div class='form-row'>
                            <div class='col-md-6 mb-3'>
                              <input type='date' name='dateNai' id='dateNai' placeholder=' Date de naissance'
                                class='form-control' required>
                            </div>
                            <div class='col-md-6 mb-3'>
                              <div class='input-group'>
                                <input type='text' name='groupe' id='groupe' placeholder=' Groupe' class='form-control'
                                  required>
                              </div>
                            </div>
                            <div class='col-md-12 mb-3'>
                              <select name='module' class="custom-select" id="inputGroupSelect02" required>
                                <option selected>------</option>
                                <?php
                                $result = mysqli_query($connection, "SELECT nomModule FROM module;");
                                if ($result) {
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['nomModule'] . "'>" . $row['nomModule'] . "</option>";
                                  }
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                        </div>
                      </section>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                      <button class='btn btn-outline-primary' type='submit' name='add-user'>Ajouter</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
      </div>
      </h2>
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
      <div class="responsive-table table">
        <?php
        // variable to store number of rows per page
        $limit = 20;
        // query to retrieve all rows from the table Countries
        $getQuery = "select * from etudie WHERE idModule = '$id_Module'";
        // get the result
        $result = mysqli_query($connection, $getQuery);
        $total_rows = mysqli_num_rows($result);
        // get the required number of pages
        $total_pages = ceil($total_rows / $limit);
        // update the active page number
        if (!isset($_GET['page'])) {
          $page_number = 1;
        } else {
          $page_number = $_GET['page'];
        }
        // get the initial page number
        $initial_page = ($page_number - 1) * $limit;

        ?>
        <table class="fs-15 w-full">
          <thead>
            <tr>
              <td>
                <div class="between-flex">
                  Apogee
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="submit" id="apogee-btn" name="apogee-btn-up">
                      <i class='bx bx-up-arrow-alt'></i>
                    </button>
                    <button type="submit" id="apogee-btn" name="apogee-btn-down">
                      <i class='bx bx-down-arrow-alt'></i>
                    </button>
                  </form>
                </div>
              </td>
              <td>
                <div class="between-flex">
                  Nom
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="submit" id="name-btn" name="name-btn-up">
                      <i class='bx bx-up-arrow-alt'></i>
                    </button>
                    <button type="submit" id="name-btn" name="name-btn-down">
                      <i class='bx bx-down-arrow-alt'></i>
                    </button>
                  </form>
                </div>
              </td>
              <td>
                <div class="between-flex">
                  Prenom
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="submit" id="prenom-btn" name="prenom-btn-up">
                      <i class='bx bx-up-arrow-alt'></i>
                    </button>
                    <button type="submit" id="prenom-btn" name="prenom-btn-down">
                      <i class='bx bx-down-arrow-alt'></i>
                    </button>
                  </form>
                </div>
              </td>
              <td>
                <div class="between-flex">
                  Groupe
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <div>
                      <button type="submit" id="grp-btn" name="grp-btn-up">
                        <i class='bx bx-up-arrow-alt'></i>
                      </button>
                      <span class='icon-down'>
                        <button type="submit" id="grp-btn" name="grp-btn-down">
                          <i class='bx bx-down-arrow-alt'></i>
                        </button>
                      </span>
                      <style>

                      </style>
                    </div>
                  </form>
                </div>
              </td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            <?php
            function affichage($row, $id_Module)
            {
              include('connection.php');
              ?>
              <tr id='myTable'>
                <td>
                  <?php echo $row['Apogee']; ?>
                </td>
                <td>
                  <?php echo $row['nom']; ?>
                </td>
                <td>
                  <?php echo $row['prenom']; ?>
                </td>
                <td>
                  <?php echo $row['id_groupe']; ?>
                </td>
                <td>
                  <div class='between-flex '>
                    <button type='button' value="<?php echo $row['Apogee']; ?>" class='btn btn-outline-primary mr-10'
                      data-toggle='modal' data-target="#myModal2-<?php echo $row['Apogee']; ?>">
                      <i class='bx bxs-edit-alt'></i>
                    </button>
                    <div id="myModal2-<?php echo $row['Apogee']; ?>" class='modal fade'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header justify-content-center'>
                            <h2 class='form-title'>Modification des données</h2>
                            <button type='button' class='close' data-dismiss='modal'
                              data-apogee="<?php echo $row['Apogee']; ?>" aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body justify-content-center'>
                            <p>
                            <section class=''>
                              <div class=''>
                                <form class='needs-validation' action='update.php' method='post' novalidate>
                                  <div class='form-row'>
                                    <div class='col-md-6 mb-3'>
                                      <input type='text' name='apogee' id='apogee' value="<?php echo $row['Apogee']; ?>"
                                        class='form-control' placeholder='Numero Apogee' required>
                                    </div>
                                    <div class='col-md-6 mb-3'>
                                      <div class='input-group'>
                                        <input type='text' class='form-control' id='cin' name='cin' placeholder='CIN'
                                          value="<?php echo $row['cin']; ?>" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class='form-row'>
                                    <div class='col-md-6 mb-3'>
                                      <div class='input-group'>
                                        <input type='text' name='name' id='name' value="<?php echo $row['nom']; ?>"
                                          class='form-control' placeholder='Nom' aria-describedby='inputGroupPrepend'
                                          required>
                                      </div>
                                    </div>
                                    <div class='col-md-6 mb-3'>
                                      <div class='input-group'>
                                        <input type='text' name='prenom' id='prenom' value="<?php echo $row['prenom']; ?>"
                                          class='form-control' name='prenom' id='prenom' placeholder='Prenom'
                                          aria-describedby='inputGroupPrepend' required>
                                      </div>
                                    </div>
                                    <div class='col-md-12 mb-3'>
                                      <div class='input-group'>
                                        <input type='email' name='email' id='email' value="<?php echo $row['email']; ?>"
                                          placeholder='Votre adress email' class='form-control'
                                          aria-describedby='inputGroupPrepend' required>
                                      </div>
                                    </div>
                                    <div class='col-md-6 mb-3'>
                                      <input type='number' name='phoneNumber' id='phoneNumber'
                                        value="<?php echo $row['telephone']; ?>" placeholder='Numero du telephone'
                                        class='form-control' required />
                                    </div>
                                    <div class='col-md-6 mb-3'>
                                      <select name="genre" class="form-select" required>
                                        <option value="<?php echo $row['genre']; ?>"><?php echo $row['genre']; ?></option>
                                        <?php
                                        if ($row['genre'] == "femme") {
                                          ?>
                                          <option value="homme">homme</option>
                                          <?php
                                        } elseif (($row['genre'] == "homme")) {
                                          ?>
                                          <option value="femme">Femme</option>
                                          <?php
                                        } else {
                                          ?>
                                          <option value="femme">Femme</option>
                                          <option value="homme">homme</option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class='form-row'>
                                    <div class='col-md-6 mb-3'>
                                      <input type='date' name='dateNai' id='dateNai'
                                        value="<?php echo $row['dateDeNaisssance']; ?>" placeholder=' Date de naissance'
                                        class='form-control' required>
                                    </div>
                                    <div class='col-md-6 mb-3'>
                                      <div class='input-group'>
                                        <input type='text' name='groupe' id='groupe'
                                          value="<?php echo $row['id_groupe']; ?>" placeholder=' Groupe'
                                          class='form-control' required>
                                      </div>
                                    </div>
                                  </div>
                                  <button class='btn btn-outline-primary' type='submit' name='u_submit'>Valider</button>
                                  <button class='btn btn-primary' data-dismiss='modal'><span>Cancel</span> </button>
                                </form>
                              </div>
                            </section>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <button type='button' class='btn btn-outline-dark alertbox'
                      data-apogee="<?php #echo $row['Apogee']; ?>">
                    </button> -->
                    <button type='button' value="<?php echo $row['Apogee']; ?>" class='btn btn-outline-dark alertbox'
                      data-toggle='modal' data-target="#myModal3-<?php echo $row['Apogee']; ?>"
                      data-apogee="<?php echo $row['Apogee']; ?>">
                      <i class='bx bx-trash'></i>
                    </button>
                    <div class='modal fade' id="myModal3-<?php echo $row['Apogee']; ?>" tabindex='-1' role='dialog'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Confirmation de la supression</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p id="error-<?php echo $row['Apogee']; ?>"></p>
                            <div class='alert alert-danger' role='alert'>
                              voulez vous vraiment supprimer l'etudiant :<br>
                              <?php echo $row['nom'] . " " . $row['prenom']; ?>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <form action='delete.php' method='post'>
                              <button type='submit' name='delete' class='btn btn-primary'
                                value="<?php echo $row['Apogee']; ?>">
                                Supprimer
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <form action='#' method='post'>
                      <a href="#myModal<?php echo $row['Apogee']; ?>" data-toggle='modal'
                        class='btn btn-circle btn-primary text-white'>
                        Detail
                      </a>
                    </form> -->
                    <button type='button' value="<?php echo $row['Apogee']; ?>"
                      class='btn btn-circle btn-primary text-white ml-1' data-toggle='modal'
                      data-target="#myModal1-<?php echo $row['Apogee']; ?>">
                      details
                    </button>
                    <?php
                    $e_res = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee='" . $row['Apogee'] . "' AND M.id_module='$id_Module' AND E.Apogee = EM.idEtudiant AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere ;");
                    if ($e_res) {
                      $e_row = mysqli_fetch_assoc($e_res);
                      ?>
                      <div id="myModal1-<?php echo $row['Apogee']; ?>" class='modal fade'>
                        <div class='modal-dialog modal-confirm'>
                          <div class='modal-content'>
                            <div class='modal-header justify-content-center'>
                              <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            </div>
                            <div class='modal-body text-center'>
                              <p>
                              <h3 class='w-fs mt-0 mb-25'>
                                <?php echo $e_row['nom'] . " " . $e_row['prenom']; ?>
                              </h3>
                              Module :
                              <?php echo $e_row['nomModule']; ?><br>
                              Filiere :
                              <?php echo $e_row['nomFiliere']; ?><br>
                              Semester :
                              <?php echo $e_row['semester']; ?><br>
                              cin :
                              <?php echo $e_row['cin']; ?><br>
                              email :
                              <?php echo $e_row['email']; ?><br>
                              telephone :
                              <?php echo $e_row['telephone']; ?><br>
                              Sexe :
                              <?php echo $e_row['genre']; ?><br>
                              Date de naissance :
                              <?php echo $e_row['dateDeNaisssance']; ?><br>
                              </p>
                              <button class='btn btn-success' data-dismiss='modal'><span>Cancel</span></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </td>
              </tr>
              <?php
            }

            function apogee_filtre($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY apogee LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function apogee_filtre_desc($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY apogee DESC LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function name_filtre($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY nom LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function name_filtre_DESC($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY nom DESC LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function prenom_filtre($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module'AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY prenom LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function prenom_filtre_desc($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module'AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY prenom DESC LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function grp_filtre($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module'AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY id_groupe LIMIT  $initial_page , $limit ;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }

            }
            function grp_filtre_dec($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module'AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY id_groupe DESC LIMIT  $initial_page , $limit;");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }
            function normal_display($id_Module, $connection, $initial_page, $limit)
            {
              $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere LIMIT  $initial_page , $limit");
              if ($res_query) {
                while ($row = mysqli_fetch_assoc($res_query)) {
                  affichage($row, $id_Module);
                }
              }
            }

            if (isset($_POST['apogee-btn-up'])) {
              apogee_filtre($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['name-btn-up'])) {
              name_filtre($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['prenom-btn-up'])) {
              prenom_filtre($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['grp-btn-up'])) {
              grp_filtre($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['apogee-btn-down'])) {
              apogee_filtre_desc($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['name-btn-down'])) {
              name_filtre_DESC($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['prenom-btn-down'])) {
              prenom_filtre_desc($id_Module, $connection, $initial_page, $limit);
            } elseif (isset($_POST['grp-btn-down'])) {
              grp_filtre_dec($id_Module, $connection, $initial_page, $limit);
            } else {
              normal_display($id_Module, $connection, $initial_page, $limit);
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="">
        <ul class="pagination">
          <?php
          // show page number with link 
          for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
            ?>
            <li class="page-item">
              <?php
              echo '<a class="page-link" href = "Etudiants.php?page=' . $page_number . '">' . $page_number . ' </a>';
              ?>
            </li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div>
  </div>

  <!--Sidebar Script-->
  <script src="js/app.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src='js/popper.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>

</html>