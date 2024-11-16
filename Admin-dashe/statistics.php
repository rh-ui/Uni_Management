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



$query = mysqli_query($connection, "SELECT COUNT(presence.statut) nbre_presence,presence.id_seance num_seance FROM presence 
WHERE presence.statut='Present' AND idModule='$id_Module'
GROUP BY presence.id_seance ORDER BY presence.id_seance;
");
if ($quer = mysqli_num_rows($query) > 0) {
    foreach ($query as $data) {
        $nbre_presence[] = $data['nbre_presence'];
    }
} else {
    $nbre_presence = "0";
}

$query2 = mysqli_query($connection, "SELECT COUNT(presence.statut) nbre_absence,presence.id_seance num_seance FROM presence 
WHERE  presence.statut='Absent' AND idModule='$id_Module'
GROUP BY presence.id_seance ORDER BY presence.id_seance;
");

if ($quer = mysqli_num_rows($query2) > 0) {
    foreach ($query2 as $data) {
        $nbre_absence[] = $data['nbre_absence'];
    }
} else {
    $nbre_absence = "0";
}


$query3 = mysqli_query($connection, "SELECT DISTINCT id_seance FROM presence WHERE idModule='$id_Module'");
if (mysqli_num_rows($query3) > 0) {
    $quer = mysqli_fetch_assoc($query3);
    foreach ($query3 as $data) {
        $num_seance[] = $data['id_seance'];
    }
} else {
    $num_seance = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14"];
}

$sql = mysqli_query($connection, "SELECT DISTINCT MONTH(date_p),SUM(downloads) FROM `files` WHERE idModule='$id_Module' GROUP BY MONTH(date_p)");
if ($quer = mysqli_num_rows($sql) > 0) {
    while ($res = mysqli_fetch_assoc($sql)) {
        $nbre_downloads[] = $res['SUM(downloads)'];
    }
} else {
    $nbre_downloads = ["0"];
}
$sql = mysqli_query($connection, "SELECT DISTINCT MONTHNAME(date_p) FROM files WHERE idModule='$id_Module'");
if ($quer = mysqli_num_rows($sql) > 0) {
    while ($res = mysqli_fetch_assoc($sql)) {
        $name_files[] = $res['MONTHNAME(date_p)'];
    }
} else {
    $name_files = ["Janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
}

$sql = mysqli_query($connection, "SELECT categorie,SUM(downloads) FROM `files` WHERE idModule='$id_Module' GROUP BY categorie;");
if ($quer = mysqli_num_rows($sql) > 0) {
    while ($res = mysqli_fetch_assoc($sql)) {
        $type[] = $res['categorie'];
        $type_downloads[] = $res['SUM(downloads)'];
    }
} else {
    $type = ["cours", "td", "tp"];
    $type_downloads = ["0", "0", "0"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiques</title>
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
            <h1 class="p-relative">Statistiques</h1>
            <div class="archive gap-0 bg-white m-20 p-10 rad-10">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card m-3" style="width: 30rem;">
                            <div class="mt-3" style="width: auto;">
                                <canvas id="presenceChart"></canvas>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                    Statistiques de présence par séance
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card m-3" style="width: 25rem;">
                            <div class="mt-3" style="width: auto;">
                                <canvas id="downloadChart"></canvas>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                    Statistiques de téléchargements des fichiers par mois
                                </h5>
                            </div>
                        </div>

                        <div class="card m-3" style="width: 25rem;">
                            <div class="mt-3" style="width: auto;">
                                <canvas id="typedownloadChart"></canvas>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                    Nombre de téléchargements total pour chaque catégorie de fichiers
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Configuration pour le graphique du taux de présence
        const presenceData = {
            labels:
                <?php echo json_encode($num_seance) ?>
            ,
            datasets: [{
                label: 'Nombre de présence',
                data: <?php echo json_encode($nbre_presence) ?>,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235)',
                pointBackgroundColor: 'rgb(54, 162, 235)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(54, 162, 235)'

            }, {
                label: 'Nombre d\'absence',
                data: <?php echo json_encode($nbre_absence) ?>,
                fill: true,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(255, 99, 132)'
            }]
        };
        const presenceConfig = {
            type: 'radar',
            data: presenceData,
            options: {
                elements: {
                    line: {
                        borderWidth: 1
                    }
                }
            },
        };

        // Configuration pour le graphique du taux de téléchargement des fichiers
        const downloadData = {
            labels: <?php echo json_encode($name_files) ?>,
            datasets: [{
                label: 'Nombre de téléchargement',
                data: <?php echo json_encode($nbre_downloads) ?>,
                backgroundColor: [
                    "rgba(54, 162, 235, 0.5)",
                ], borderColor: [
                    "rgba(54, 162, 235, 1)",
                ],
                borderWidth: 1
            }]
        };
        const downloadConfig = {
            type: 'bar',
            data: downloadData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };
        //configuration de nombre de telechargement par type
        const typeDownloadData = {
            labels:
                <?php echo json_encode($type) ?>
            ,
            datasets: [{
                label: 'Nombre de téléchargements total',
                data: <?php echo json_encode($type_downloads) ?>,
                backgroundColor: [
                    'rgb(255, 99, 132,0.8)',
                    'rgb(54, 162, 235)',
                    'rgb(54, 162, 235,0.3)'
                ],
                hoverOffset: 4
            }]
        };
        const typeDownloadConfig = {
            type: 'doughnut',
            data: typeDownloadData,
        };

        var presenceChart = new Chart(
            document.getElementById('presenceChart'),
            presenceConfig
        );

        var downloadChart = new Chart(
            document.getElementById('downloadChart'),
            downloadConfig
        );
        var downloadChart = new Chart(
            document.getElementById('typedownloadChart'),
            typeDownloadConfig
        );
    </script>

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