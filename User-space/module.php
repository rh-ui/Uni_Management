<?php
include('connection.php');
$id = $_GET['id_module'];
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
<style>
    .item-c {
        width: 50px;
    }
</style>

<body>
    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">

            <!-- Start Head -->
            <?php include('head.php') ?>
            <!-- End Head -->
            <div id="add-user">
                <h1 class="p-relative">fichiers

                </h1>
            </div>
            <div class="projects p-20 bg-white rad-10 m-20">
                <!-- Start Cours table -->
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Cours
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="responsive-table">
                                    <table class="w-full text-center mb-3">

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="responsive-table">
                                                        <table class="w-full">
                                                            <thead>
                                                                <tr>
                                                                    <td>fichier</td>
                                                                    <td>size</td>
                                                                    <td>Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $get_tp = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id' AND categorie = 'cours'");
                                                                if ($get_tp) {
                                                                    while ($tp = mysqli_fetch_assoc($get_tp)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $extension = $tp['extention'];
                                                                                if (in_array($extension, ['zip'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/zip.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/pdf.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/png.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $tp['size'] / 1000 . " Kbs"; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="vn-green"
                                                                                    style="text-align: center; text-decoration: none;color:grey">
                                                                                    <a href="download.php?id_file=<?php echo $tp['id'] ?> "
                                                                                        class="btn btn-circle btn-primary text-white"
                                                                                        role="button">download
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Travaux Dirigés
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="responsive-table">
                                    <table class="w-full text-center mb-3">

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="responsive-table">
                                                        <table class="w-full">
                                                            <thead>
                                                                <tr>
                                                                    <td>fichier</td>
                                                                    <td>size</td>
                                                                    <td>Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $get_tp = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id' AND categorie = 'td'");
                                                                if ($get_tp) {
                                                                    while ($tp = mysqli_fetch_assoc($get_tp)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $extension = pathinfo($tp['name'], PATHINFO_EXTENSION);
                                                                                if (in_array($extension, ['zip'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/zip.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/pdf.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/png.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $tp['size'] / 1000 . " Kbs"; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="vn-green"
                                                                                    style="text-align: center; text-decoration: none;color:grey">
                                                                                    <a href="download.php?id_file=<?php echo $tp['id'] ?> "
                                                                                        class="btn btn-circle btn-primary text-white"
                                                                                        role="button">download
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Travaux Pratiques
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="responsive-table">
                                    <table class="w-full text-center mb-3">

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="responsive-table">
                                                        <table class="w-full">
                                                            <thead>
                                                                <tr>
                                                                    <td>fichier</td>
                                                                    <td>size</td>
                                                                    <td>Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $get_tp = mysqli_query($connection, "SELECT * FROM files WHERE idModule='$id' AND categorie = 'tp'");
                                                                if ($get_tp) {
                                                                    while ($tp = mysqli_fetch_assoc($get_tp)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $extension = pathinfo($tp['name'], PATHINFO_EXTENSION);
                                                                                if (in_array($extension, ['zip'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/zip.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['pdf'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/pdf.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                } elseif (in_array($extension, ['png']) || in_array($extension, ['jpg']) || in_array($extension, ['jpeg'])) {
                                                                                    ?>
                                                                                    <div class='file p-10 rad-10 '>
                                                                                        <div class='txt-c between-block'>
                                                                                            <img class='mt-15 mb-15 item-c'
                                                                                                src='imgs/png.svg'>
                                                                                            <div class='mb-10 fs-14'>
                                                                                                <?php echo $tp['name'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $tp['size'] / 1000 . " Kbs"; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="vn-green"
                                                                                    style="text-align: center; text-decoration: none;color:grey">
                                                                                    <a href="download.php?id_file=<?php echo $tp['id'] ?> "
                                                                                        class="btn btn-circle btn-primary text-white"
                                                                                        role="button">download
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Cours table -->
                <!-- Start TP table -->

                <!-- End TP table -->
                <!-- Start td table -->

                <!-- End td table -->
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


        <script src="js/noti.js"></script>

</body>


</html>