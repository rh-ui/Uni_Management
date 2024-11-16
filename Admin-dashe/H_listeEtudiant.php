<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$id_groupe = $_SESSION['groupe'];
$id_Module = $_SESSION['id_module'];

function apogee_filtre($id_Module, $id_groupe, $connection, $initial_page, $limit)
{
    $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND E.id_groupe = '$id_groupe' AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY apogee LIMIT  $initial_page , $limit;");
    if ($res_query) {
        while ($row = mysqli_fetch_assoc($res_query)) {
            affichage($row, $connection,$initial_page, $limit);
        }
    }
}
function apogee_filtre_desc($id_Module, $id_groupe, $connection, $initial_page, $limit)
{
    $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND E.id_groupe = '$id_groupe' AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY apogee DESC LIMIT  $initial_page , $limit ;");
    if ($res_query) {
        while ($row = mysqli_fetch_assoc($res_query)) {
            affichage($row, $connection,$initial_page, $limit);
        }
    }
}
function name_filtre($id_Module, $id_groupe, $connection, $initial_page, $limit)
{
    $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND E.id_groupe = '$id_groupe' AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY nom LIMIT  $initial_page , $limit ;");
    if ($res_query) {
        while ($row = mysqli_fetch_assoc($res_query)) {
            affichage($row, $connection,$initial_page, $limit);
        }
    }

}
function name_filtre_DESC($id_Module, $id_groupe, $connection, $initial_page, $limit)
{
    $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND E.id_groupe = '$id_groupe' AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere GROUP BY apogee ORDER BY nom DESC LIMIT  $initial_page , $limit ;");
    if ($res_query) {
        while ($row = mysqli_fetch_assoc($res_query)) {
            affichage($row, $connection,$initial_page, $limit);
        }
    }

}
function normal_display($id_Module, $id_groupe, $connection, $initial_page, $limit)
{
    $res_query = mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F WHERE E.Apogee = EM.idEtudiant AND E.id_groupe = '$id_groupe' AND M.id_module = '$id_Module' AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere LIMIT  $initial_page , $limit  ;");
    if ($res_query) {
        while ($row = mysqli_fetch_assoc($res_query)) {
            affichage($row, $connection,$initial_page, $limit);
        }
    }

}



function affichage($row, $connection,$initial_page, $limit)
{
    ?>
    <tr id="<?php echo $row['Apogee']; ?>">
        <td>
            <?php echo $row['Apogee']; ?>
        </td>
        <td>
            <?php echo $row['nom'] . " " . $row['prenom']; ?>
        </td>
        <td>
            <div class="c-text">
                <?php
                $row_p = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM etudiant E,module M,etudie EM,module_filiere MF,filiere F,presence P WHERE E.Apogee='" . $row['Apogee'] . "' AND E.Apogee = EM.idEtudiant AND EM.idModule = M.id_module AND M.id_module=MF.idModule AND F.idFiliere = MF.idFiliere AND P.idEtudiant=E.Apogee AND P.idModule = M.id_module  AND M.id_module = '" . $row['idModule'] . "';"));
                if ($row_p) {
                    ?>
                    <!-- Start details de chaque etudiant -->
                    <button type="button" class="btn btn-primary detail" data-toggle="modal"
                        data-target="#myModal-<?php echo $row_p['Apogee'] ?>">
                        details
                    </button>
                    <div class="modal fade" id="myModal-<?php echo $row_p['Apogee'] ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content txt-c" id="myModal-<?php $row_p['Apogee'] ?>">
                                <div class="m-15 item-c">
                                    <button type="button" class="close" data-dismiss="modal"
                                        data-apogee="<?php echo $row_p['Apogee']; ?>" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title txt-c" id="myModal-<?php echo $row_p['Apogee']; ?>">
                                        Module :
                                        <?php echo " " . $row['nomModule'] . "  (" . $row_p['nomFiliere'] . "-" . $row['semester'] . ") "; ?>
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <h4 class=" txt-c mb-25" id="myModal-<?php echo $row_p['Apogee']; ?>">
                                        <?php echo $row_p['nom'] . " " . $row_p['prenom']; ?>
                                    </h4>
                                    <div class='container-sm px-4'>
                                        <div class="responsive-table">
                                            <table class="fs-20 w-full">
                                                <thead>
                                                    <tr>
                                                        <td> Date du scan </td>
                                                        <td> Statut </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $apogee = $row_p['Apogee'];
                                                    $idModule = $row_p['idModule'];
                                                    $res = mysqli_query($connection, "SELECT * FROM presence,etudiant,module where presence.idEtudiant = '$apogee' AND presence.idModule = '$idModule' AND module.id_module = presence.idModule AND etudiant.Apogee=presence.idEtudiant;");
                                                    if ($res) {
                                                        while ($row_s = mysqli_fetch_assoc($res)) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $row_s['date_p']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row_s['statut']; ?>
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
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End details de chaque etudiant -->
                    <!-- Start Statistics de chaque etudiant -->
                    <?php
                    $num_seance = [];
                    $nbre_presence = [];
                    $nbre_absence = [];
                    $query = mysqli_query($connection, "SELECT DISTINCT MONTHNAME(presence.date_p) AS nom_mois
                                                                FROM
                                                                    presence
                                                                WHERE
                                                                presence.idEtudiant = '{$row_p['Apogee']}' AND presence.idModule = '".$_SESSION['id_module']."'
                                                                ORDER BY
                                                                MONTH(presence.date_p)");
                            while ($data = mysqli_fetch_assoc($query)) {
                                $num_seance[] = $data['nom_mois'];
                            }
                            $query2 = mysqli_query($connection, "SELECT 
                            MONTHNAME(presence.date_p) AS nom_mois, 
                            COUNT(*) AS nbre_presence
                        FROM 
                            presence
                        WHERE 
                            presence.idEtudiant = '{$row_p['Apogee']}' AND presence.statut = 'Present' AND presence.idModule = '".$_SESSION['id_module']."'
                        GROUP BY 
                            MONTH(presence.date_p), nom_mois
                        ORDER BY 
                            MONTH(presence.date_p)");  
                
                                            while ($data = mysqli_fetch_assoc($query2)) {
                                                $nbre_presence[] = $data['nbre_presence'];
                                            }
                                            $query3 = mysqli_query($connection, "SELECT 
                                            MONTHNAME(presence.date_p) AS nom_mois, 
                                            COUNT(*) AS nbre_absence
                                        FROM 
                                            presence
                                        WHERE 
                                            presence.idEtudiant = '{$row_p['Apogee']}' AND presence.statut = 'Absent' AND presence.idModule = '".$_SESSION['id_module']."'
                                        GROUP BY 
                                            MONTH(presence.date_p), nom_mois
                                        ORDER BY 
                                            MONTH(presence.date_p)");
                                
                                                            while ($data = mysqli_fetch_assoc($query3)) {
                                                                $nbre_absence[] = $data['nbre_absence'];
                                                            }
                    ?>
                    <button type="button" class="btn btn-outline-info " data-toggle="modal"
                        data-target="#myModal2-<?php echo $row_p['Apogee'] ?>">
                        statistics
                    </button>
                    <div div class="modal fade" id="myModal2-<?php echo $row_p['Apogee'] ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content" id="myModal2-<?php $row_p['Apogee'] ?>">
                                <div class="m-15 item-c">
                                    <button type="button" class="close" data-dismiss="modal"
                                        data-apogee="<?php echo $row['Apogee']; ?>" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title txt-c" id="myModal2-<?php echo $row_p['Apogee']; ?>">
                                        Module :
                                        <?php echo " " . $row_p['nomModule'] . "  (" . $row_p['nomFiliere'] . "-" . $row_p['semester'] . ") "; ?>
                                    </h5>
                                    <div class="modal-body">
                                        <div class="targets p-15 bg-white rad-10">
                                            <div style="width: 100%;">
                                               <canvas id="myChart<?= $row_p['Apogee']; ?>"></canvas>
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
                    <script>
                                var data<?= $row_p['Apogee']; ?> = {
                                    labels: <?= json_encode($num_seance); ?>,
                                    datasets: [{
                                        label: "Nombre de présences",
                                        data: <?= json_encode($nbre_presence); ?>,
                                        backgroundColor: "rgba(54, 162, 235, 0.5)",
                                        borderColor: "rgba(54, 162, 235, 1)",
                                        borderWidth: 1
                                    },
                                    {
                                        label: "Nombre d'absences",
                                        data: <?= json_encode($nbre_absence); ?>,
                                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                                        borderColor: "rgba(255, 99, 132, 1)",
                                        borderWidth: 1
                                    }
                                    ]
                                };

                                var config<?= $row_p['Apogee']; ?> = {
                                    type: "bar",
                                    data: data<?= $row_p['Apogee']; ?>,
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                stepSize: 1
                                            }
                                        }
                                    }
                                };

                                var myChart<?= $row_p['Apogee']; ?> = new Chart(document.getElementById("myChart<?= $row_p['Apogee']; ?>"), config<?= $row['Apogee']; ?>);
                            </script>
                        <!-- End Statistics de chaque etudiant -->
                        <?php
                } else {
                    ?>
                        <!-- Start details de chaque etudiant -->
                        <button type="button" class="btn btn-primary detail" data-toggle="modal"
                            data-target="#myModal-<?php echo $row['Apogee'] ?>">
                            details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal-<?php echo $row['Apogee'] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen-sm-down">
                                <div class="modal-content txt-c" id="myModal-<?php $row['Apogee'] ?>">
                                    <div class="m-15 item-c ">
                                        <button type="button" class="close" data-dismiss="modal"
                                            data-apogee="<?php echo $row['Apogee']; ?>" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title txt-c" id="myModal-<?php echo $row['Apogee']; ?>">
                                            Module :
                                            <?php echo " " . $row['nomModule'] . "  (" . $row['nomFiliere'] . "-" . $row['semester'] . ") "; ?>
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <h4 class=" txt-c mb-25" id="myModal-<?php echo $row['Apogee']; ?>">
                                            <?php echo $row['nom'] . " " . $row['prenom']; ?>
                                        </h4>
                                        <div class="p-30">
                                            <img src="imgs/no_data_found.png" class="img-fluid img-thumbnail" alt="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End details de chaque etudiant -->
                        <!-- Start Statistique de presence pour chaque etudiant -->
                        <button type="button" class="btn btn-outline-info " data-toggle="modal"
                            data-target="#myModal2-<?php echo $row['Apogee'] ?>">
                            statistics
                        </button>
                        <div div class="modal fade" id="myModal2-<?php echo $row['Apogee'] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" id="myModal2-<?php $row['Apogee'] ?>">
                                    <div class="m-15 item-c">
                                        <button type="button" class="close" data-dismiss="modal"
                                            data-apogee="<?php echo $row['Apogee']; ?>" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title txt-c" id="myModal2-<?php echo $row['Apogee']; ?>">
                                            Module :
                                            <?php echo " " . $row['nomModule'] . "  (" . $row['nomFiliere'] . "-" . $row['semester'] . ") "; ?>
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="targets p-15 bg-white rad-10">
                                            <h2 class="w-fs mt-0 mb-10">
                                                <?php echo $row['nom'] . " " . $row['prenom']; ?>
                                            </h2>
                                            <div class="p-30">
                                                <img src="imgs/no_data_found.png" class="img-fluid img-thumbnail" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Statistique de presence pour chaque etudiant -->
                        <?php
                }
                ?>
                </div>
        </td>
    </tr>
    <?php

?>
<?php
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h2 class="w-fs mt-0 mb-20">Liste des etudiants :</h2>
                <h2 class="w-fs mt-0 mb-20 txt-c">Groupe
                    <?php echo $id_groupe; ?>
                </h2>
                <div class="responsive-table table">
                <?php
                // variable to store number of rows per page
                $limit = 20;
                // query to retrieve all rows from the table Countries
                $getQuery = "select * from presence,etudiant WHERE presence.idEtudiant=etudiant.Apogee AND etudiant.id_groupe='$id_groupe' AND idModule = '$id_Module'";
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
                                        Nom Complet
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
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (isset($_POST['apogee-btn-up'])) {
                                apogee_filtre($id_Module, $id_groupe, $connection,$initial_page, $limit);
                            } elseif (isset($_POST['name-btn-up'])) {
                                name_filtre($id_Module, $id_groupe, $connection,$initial_page, $limit);
                            } elseif (isset($_POST['name-btn-down'])) {
                                name_filtre_DESC($id_Module, $id_groupe, $connection,$initial_page, $limit);
                            } elseif (isset($_POST['apogee-btn-down'])) {
                                apogee_filtre_desc($id_Module, $id_groupe, $connection,$initial_page, $limit);
                            } else {
                                normal_display($id_Module, $id_groupe, $connection,$initial_page, $limit);
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
                            echo '<a class="page-link" href = "H_listeEtudiant.php?page=' . $page_number . '">' . $page_number . ' </a>';
                        ?>
                        </li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start statistics script -->
    <script>
        const data = {
            labels:
                <?php echo json_encode($num_seance) ?>
            ,
            datasets: [{
                label: 'Taux de présence',
                data: <?php echo json_encode($nbre_presence) ?>,
                fill: true,
                backgroundColor: 'rgba(125,236,255,0.2)',
                borderColor: 'rgb(125,236,255)',
                pointBackgroundColor: 'rgb(125,236,255)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(125,236,255)'

            }, {
                label: 'Taux d\'absence',
                data: <?php echo json_encode($nbre_absence) ?>,
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
</body>

</html>