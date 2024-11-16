<?php
include('connection.php');
?>
<?php
function getNomMois($numeroMois)
{
    $nomsMois = [
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Décembre'
    ];
}
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">

            <!-- Start Head -->
            <?php include('head.php') ?>
            <!-- End Head -->
            <!--Students table-->

            <div id="add-user">

            </div>
            <div class="projects p-20 bg-white rad-10 m-20">
                <div class="head bg-white p-15 between-flex">
                    <h2 class="w-fs mt-0 mb-20"></h2>

                </div>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>
                                    <div class="between-flex">
                                        Module

                                    </div>
                                </td>
                                <td>
                                    <div class="between-flex">
                                        Nombre absence

                                    </div>
                                </td>
                                <td>
                                    <div class="between-flex">
                                        Nombre presence

                                    </div>
                                </td>
                                <td>
                                    <div class="between-flex">
                                        detail

                                    </div>
                                </td>

                            </tr>
                        </thead>
                        <tbody>
                            <tr id="<?php echo $row['Apogee']; ?>">
                                <?php
                                $id_etudiant = $_SESSION['user_id'];
                                $sql = "SELECT DISTINCT module.id_module,module.nomModule FROM module,etudie,presence where presence.idModule=module.id_module and presence.idEtudiant=etudie.idEtudiant and module.id_module=etudie.idModule AND etudie.idEtudiant=$id_etudiant";
                                $result = mysqli_query($connection, $sql);
                                ?>


                            <tr id="<?php echo $row['Apogee']; ?>">
                                <?php while ($module = mysqli_fetch_assoc($result)) {
                                    $idMOdule = $module['id_module'];
                                    $nbr1 = mysqli_fetch_assoc(mysqli_query($connection, "SELECT count(*) as nb FROM presence where presence.idModule=$idMOdule AND presence.statut='present' AND  presence.idEtudiant=$id_etudiant"));
                                    $nbr2 = mysqli_fetch_assoc(mysqli_query($connection, "SELECT count(*) as nbr FROM presence where presence.idModule=$idMOdule AND presence.statut='absent' AND   presence.idEtudiant=$id_etudiant"));


                                    ?>
      <?php
      $nbre_downloads1 = [];
      $nbre_downloads2 = [];
      $name_files = [];
      $id_etudiant = $_SESSION['user_id'];
      $sqle = mysqli_query($connection, "SELECT DISTINCT MONTHNAME(date_p) FROM presence WHERE presence.idEtudiant= $id_etudiant AND presence.idModule=$idMOdule   GROUP BY MONTH(date_p) ");
      $reqe = mysqli_query($connection, "SELECT  COUNT(*) as nbr1 , MONTHNAME(presence.date_p) AS nom_mois FROM presence WHERE presence.idEtudiant= $id_etudiant AND presence.idModule=$idMOdule AND presence.statut='present' GROUP BY MONTH(presence.date_p), nom_mois ORDER BY MONTH(presence.date_p) ");
      $reqee = mysqli_query($connection, "SELECT  COUNT(*) as nbr2,MONTHNAME(presence.date_p) AS nom_mois FROM presence WHERE presence.idEtudiant= $id_etudiant AND presence.idModule=$idMOdule AND presence.statut='absent' GROUP BY MONTH(presence.date_p), nom_mois ORDER BY MONTH(presence.date_p)  ");
      $num_mois = mysqli_num_rows($sqle);
      $num_presence = mysqli_num_rows($reqe);
      $num_abscence = mysqli_num_rows($reqee);


      if ($quer = mysqli_num_rows($sqle) > 0) {
          while ($rese = mysqli_fetch_assoc($sqle)) {
              $name_files[] = $rese['MONTHNAME(date_p)'];
          }
      } else {
          $name_files = ["Janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
      }
      //   $res = mysqli_fetch_assoc($reqe);
//   if($num_mois>$num_presence || $res['nom_mois']!= $name_files[0]){
//      $boucle=$num_mois-$num_presence;
//      for($i=0;$i<$boucle;$i++){
//         $nbre_downloads1[]=0;
//      }
//      if ($quer = mysqli_num_rows($sqle) > 0 )
//      while ($res = mysqli_fetch_assoc($reqe)){
//         $nbre_downloads1[]= $res['nbr1'];
//      }else{
//         $nbre_downloads1 = ["0"];
//       }
//   }
  



      if ($quer = mysqli_num_rows($sqle) > 1) {
          while ($res = mysqli_fetch_assoc($reqe)) {
              if (($quer = mysqli_num_rows($reqe)) == 1 && $res['nom_mois'] != $name_files[0]) {
                  $nbre_downloads1[] = 0;
                  $nbre_downloads1[] = $res['nbr1'];
                  break;
              } else {
                  $nbre_downloads1[] = $res['nbr1'];
              }
          }
      } else {
          $nbre_downloads1 = ["0"];
      }
      if ($quer = mysqli_num_rows($sqle) > 0) {
          while ($res = mysqli_fetch_assoc($reqee)) {
              $nbre_downloads2[] = $res['nbr2'];
          }


      } else {
          $nbre_downloads2 = ["0"];
      }

      //   if ($quer = mysqli_num_rows($sqle) > 0) {
//       while ($rese = mysqli_fetch_assoc($sqle)) {
//           $name_files[] = $rese['MONTHNAME(date_p)'];
//       }
//   }else{
//       $name_files = ["Janvier", "février", "mars", "avril","mai", "juin", "juillet", "août", "septembre", "octobre", "novembre" , "décembre"];
//   }
  
      ?>



                                    <?php
                                    $req = "SELECT * FROM module,etudie,presence where presence.idModule=module.id_module and presence.idEtudiant=etudie.idEtudiant and module.id_module=etudie.idModule AND etudie.idEtudiant=$id_etudiant AND module.id_module=$idMOdule";
                                    $rel = mysqli_query($connection, $req);
                                    ?>



                                    <td>
                                        <div class="between-flex">
                                            <?php echo $module['nomModule']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="between-flex">
                                            <?php echo $nbr2['nbr']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="between-flex">
                                            <?php echo $nbr1['nb']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary detail" data-toggle="modal"
                                            data-target="#myModal-<?php echo $module['id_module']; ?>">Detail</button>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                            id="myModal-<?php echo $module['id_module']; ?>"
                                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg"
                                                id="myModal-<?php echo $module['id_module']; ?>">
                                                <div class="modal-content"
                                                    id="myModal-<?php echo $module['id_module']; ?>">
                                                    <div class="modal-header"
                                                        id="myModal-<?php echo $module['id_module']; ?>">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Rapport de
                                                            presence</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </div>
                                                    <div class="modal-body"
                                                        id="myModal-<?php echo $module['id_module']; ?>">
                                                        <div class="responsive-table">
                                                            <table class="fs-20 w-full">
                                                                <thead>
                                                                    <tr>
                                                                        <td> Date du scan</td>
                                                                        <td>Statut</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php while ($scanners = mysqli_fetch_assoc($rel)) { ?>
                                                                            <td>
                                                                                <?php echo $scanners['date_p']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $scanners['statut']; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                    <!-- Start Statistique de presence pour chaque etudiant -->
                    <button type="button" class="btn btn-outline-info " data-toggle="modal"
                        data-target="#myModal2-<?php echo $module['id_module'] ?>">
                        statistics
                    </button>
                    <div div class="modal fade" id="myModal2-<?php echo $module['id_module'] ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content" id="myModal2-<?php $module['id_module'] ?>">
                                <div class="m-15 item-c">
                                    <button type="button" class="close" data-dismiss="modal"
                                        data-apogee="<?php echo $module['id_module']; ?>" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title txt-c" id="myModal2-<?php echo $module['id_module']; ?>">
                                        Statistique :

                                    </h5>
                                    <div class="modal-body">
                                        <div class="targets p-15 bg-white rad-10">
                                            <div style="width: 100%;">
                                                <canvas id="myChart<?= $module['id_module']; ?>"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Statistique de presence pour chaque etudiant -->
                    <script>
                        var data<?= $module['id_module']; ?> = {
                            labels: <?= json_encode($name_files); ?>,
                            datasets: [{
                                label: "Nombre de présences",
                                data: <?= json_encode($nbre_downloads1); ?>,
                                backgroundColor: "rgba(54, 162, 235, 0.5)",
                                borderColor: "rgba(54, 162, 235, 1)",
                                borderWidth: 1
                            },
                            {
                                label: "Nombre d'absences",
                                data: <?= json_encode($nbre_downloads2); ?>,
                                backgroundColor: "rgba(255, 99, 132, 0.5)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                borderWidth: 1
                            }
                            ]
                        };

                        var config<?= $module['id_module']; ?> = {
                            type: "bar",
                            data: data<?= $module['id_module']; ?>,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        stepSize: 1
                                    }
                                }
                            }
                        };

                        var myChart<?= $module['id_module']; ?> = new Chart(document.getElementById("myChart<?= $module['id_module']; ?>"), config<?= $module['id_module']; ?>);
                    </script>


                    </td>


                    </tr>
                <?php } ?>

                </tbody>
                </table>
            </div>
        </div>
    </div>



    <!--Sidebar Script-->
    <script src="js/app.js"></script>
    <!-- JQUERY -->
    <script language=JavaScript>
        function chercher() {
            const x = document.getElementById("sr");
            window.location = 'files.php?sr=' + x.value;
        }


    </script>
    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
    <script src="js/calendar.js"></script>
    <script src="js/prog.js"></script>
    <script src="js/noti.js"></script>
    <script src='js/popper.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    </script>


    <script src="js/noti.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = {
            labels:
                <?php echo json_encode($num_seance) ?>
            ,
            datasets: [{
                label: 'Taux de présence',
                data: <?php echo json_encode($nbre_downloads1) ?>,
                fill: true,
                backgroundColor: 'rgba(125,236,255,0.2)',
                borderColor: 'rgb(125,236,255)',
                pointBackgroundColor: 'rgb(125,236,255)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(125,236,255)'

            }, {
                label: 'Taux d\'absence',
                data: <?php echo json_encode($nbre_downloads2) ?>,
                fill: true,
                backgroundColor: 'rgba(82,48,209, 0.2)',
                borderColor: 'rgb(82,48,209)',
                pointBackgroundColor: 'rgb(82,48,209)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(82,48,209)'
            }]
        };
        const config = {
            type: 'radar',
            data: data,
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            },
        };
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

    <!-- End statistics script -->




</body>


</html>