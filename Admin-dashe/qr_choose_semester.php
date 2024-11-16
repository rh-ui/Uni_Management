<?php
session_start();
include('connection.php');
$prof_id = $_SESSION['user_id'];
$getidmodule = mysqli_query($connection, "SELECT id_module FROM module WHERE idProfesseur ='$prof_id'");
if ($getidmodule) {
    $getidmodule = mysqli_fetch_assoc($getidmodule);
    $id_module = $getidmodule['id_module'];
}

if (isset($_POST['file-btn'])) {
    $_SESSION['id_module'] = $_POST['file-btn'];
    header('Location:generateQr.php');
    die();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../login/adminLogin.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Presence</title>
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
            <div class="archive d-grid m-20 gap-20 p-10 rad-10">
                <?php
                $res = mysqli_query($connection, "SELECT * FROM module_filiere mf,module m where m.id_module=mf.idModule AND idProfesseur ='$prof_id';");
                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <div class="card" style="width: 18rem;">
                            <img src="imgs\qr_2.jpg" class="card-img-top" alt="groupe image">
                            <div class="card-body center-flex">
                                <h5 class="card-title"></h5>
                                <p class="card-text"></p>
                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                                    <button type="submit" name='file-btn' class="btn btn-outline-primary"
                                        value="<?php echo $row['idModule']; ?>">
                                        <?php echo $row['nomModule'] . " (" . $row['semester'] . ")"; ?>
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
    <script src='js/popper.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>