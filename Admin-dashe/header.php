<?php
$get_notifi_result = mysqli_query($connection, "SELECT * FROM message,notification WHERE message.idMessage  = notification.id_message AND message.id_recepteur = '$prof_id' AND notification.status='unread';");
?>

<!-- Start Head -->
<div class="head bg-white p-15 between-flex">
    <div class="search">
        <div class="input-group pl-20">
            <input type="text" class="form-control" placeholder="recherche" onkeyup="filtrer()" id="maRecherche">
        </div>
    </div>
    <div class="icons d-flex align-center">
        <a href="#add_mod" class='btn btn-link btn-lg ' data-toggle="modal" data-target="#add_mod">
            <i class='bx bxs-add-to-queue link-dark'></i>
            <span class="ml-2 default font-weight-normal text-dark w-fs"></span>
        </a>
        <div class="modal fade" id="add_mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau module</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="add_module.php" method="post">
                        <div class="modal-body">
                            <section class=''>
                                <div class=''>
                                    <div class='form-row'>
                                        <div class='col-md-12 mb-3'>
                                            <input type='text' name='nom' id='nom' class='form-control'
                                                placeholder='Nom du module' required>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col-md-12 mb-3'>
                                            <select name='filiere' class="custom-select" id="inputGroupSelect02"
                                                required>
                                                <?php
                                                $result = mysqli_query($connection, "SELECT * FROM filiere;");
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['idFiliere'] . "'>" . $row['nomFiliere'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col-md-12 mb-3'>
                                            <select name='semester' class="custom-select" id="inputGroupSelect02"
                                                required>
                                                <?php
                                                $result2 = mysqli_query($connection, "SELECT * FROM module_filiere;");
                                                if ($result2) {
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        echo "<option value='" . $row2['semester'] . "'>" . $row2['semester'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="submit" name="add_mod" value="" class="btn btn-primary">Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (mysqli_num_rows($get_notifi_result) > 0) {
            ?>
            <span class="notification p-relative" onclick="toggleNotifi()">
                <i class="fa-regular fa-bell fa-lg"></i>
                <div class="notifi-box " id="box">
                    <?php
                    ?>
                    <h2>Notifications </h2>
                    <?php
                    while ($notification = mysqli_fetch_assoc($get_notifi_result)) {
                        $get_etudiant = mysqli_query($connection, "SELECT * FROM message,etudiant WHERE message.id_etudiant = etudiant.Apogee AND message.idMessage ='" . $notification['id_message'] . "';");
                        if ($get_etudiant) {
                            $get_etudiant = mysqli_fetch_assoc($get_etudiant);
                            $nom = $get_etudiant['nom'];
                            $prenom = $get_etudiant['prenom'];
                            $profile = $get_etudiant['profile'];
                        }
                        ?>
                        <div class="notifi-item">
                            <img src="..\User-space\<?php echo $get_etudiant['profile']; ?>" alt="img">
                            <a href="msgComplet.php?id=<?php echo $notification['id_message']; ?>" name='notifi'
                                class="text-dark fs-15" style="text-decoration : none;">
                                <div class="text">
                                    <h4 class="text-dark fs-15">
                                        <?php
                                        echo $nom . " " . $prenom;
                                        ?>
                                    </h4>
                                    <p>
                                        <?php echo $notification['objet']; ?>

                                    </p>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </span>
            <?php
        } else {
            ?>
            <span class="p-relative" onclick="toggleNotifi()">
                <i class="fa-regular fa-bell fa-lg"></i>
                <div class="notifi-box" id="box">
                    <h2>Notifications </h2>
                </div>
            </span>
            <?php
        }
        ?>

        <div class="btn-group mr-4">
            <?php
            $result = mysqli_query($connection, "SELECT * from professeur where num_serie ='$prof_id'");
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                ?>
                <a class="btn " data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <img src="<?php echo $row['profile']; ?>" alt="" />
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-end">
                    <!-- <li>
                        <h6 class="dropdown-header">Dropdown header</h6>
                    </li> -->
                    <li><a class="dropdown-item" href="settings.php">Voir profile</a></li>
                    <li><a class="dropdown-item" href="Etudiants.php?logout">Se deconnecter</a></li>
                </ul>
                <?php
            }
            ?>

        </div>
    </div>
</div>
<!-- End Head  -->
<script src="js/notification.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>