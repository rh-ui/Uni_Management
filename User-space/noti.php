<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="noti.css" />
    <title>Document</title>
</head>

<body>
    <div class="head bg-white p-15 between-flex">
        <div class="search">
        </div>
        <div class="icons d-flex align-center">
            <span class="notification p-relative">
                <i class="fa-regular fa-bell fa-lg" onclick="toggleNotifi()"></i>
            </span>
            <div class="notifi-box " id="box">
                <h2>Notifications </h2>
                <?php
                $db_host = 'localhost';
                $db_user = 'root';
                $db_password = '';
                $db_name = 'project(1)';
                $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
                $id_recepteur = $_SESSION['user_id'];
                $sql = "SELECT * from notification,message  where message.idMessage=notification.id_message AND message.id_recepteur=$id_recepteur AND  status='unread'";
                $rsl = mysqli_query($connection, $sql);
                ?>
                <?php while ($notifications = mysqli_fetch_assoc($rsl)) { ?>
                    <?php
                    $recepteur = $notifications['id_expediteur'];
                    $req = "SELECT * from professeur where num_serie='$recepteur'";
                    $result = mysqli_query($connection, $req);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="notifi-item">
                        <img src="imgs/avatar.jpg" alt="img">
                        <div class="text">
                            <h4>
                                <?php echo $row['nom'] . " " . $row['prenom']; ?>
                            </h4>
                            <a href="test-msg.php?pid_msg=<?php echo $notifications['id_notifi'] ?>"
                                style="text-decoration:none;">
                                <p>
                                    <?php echo $notifications['objet']; ?>
                                </p>
                            </a>
                        </div>
                    </div>
                <?php }
                ; ?>
            </div>
            <img src="imgs/avatar.jpg" alt="" />
        </div>
    </div>
    <script src="js/noti.js"></script>
</body>

</html>