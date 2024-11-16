<body>
  <div class="head bg-white p-15 between-flex">
    <div class="search">
    </div>
    <?php
    $id_recepteur = $_SESSION['user_id'];
    $sql = "SELECT * from notification,message  where message.idMessage=notification.id_message AND message.id_recepteur=$id_recepteur AND  status='unread'";
    $rsl = mysqli_query($connection, $sql);
    ?>
    <?php if (mysqli_num_rows($rsl) > 0) { ?>
      <div class="icons d-flex align-center">
        <span class="notification p-relative">
          <i class="fa-regular fa-bell fa-lg" onclick="toggleNotifi()"></i>
        </span>

      <?php } else { ?>


        <div class="icons d-flex align-center">
          <span class="">
            <i class="fa-regular fa-bell fa-lg" onclick="toggleNotifi()"></i>
          </span>


        <?php } ?>
        <div class="notifi-box " id="box">
          <h2>Notifications </h2>

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
                <a href="mesagestest.php?id_message=<?php echo $notifications['id_message'] ?>"
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
        <?php
        $id_etudiant = $_SESSION['user_id'];
        $sql = "SELECT * from etudiant where Apogee=$id_etudiant";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result)

          ?>

        <div class="btn-group droplef ">
          <a class="btn " data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <img src="<?php echo $row['profile']; ?>" alt="" />
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="profile.php">Voir profile</a></li>
            <li><a class="dropdown-item" href="index.php?logout">Se deconnecter</a></li>
          </ul>
        </div>

      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>