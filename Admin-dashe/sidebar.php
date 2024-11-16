<link rel="stylesheet" href="css/master.css" />
<link rel="stylesheet" href="css/boxicons.min.css">
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />

<body class="shrink shrink1">
    <nav>
        <div class="sidebar-top">
            <span class="shrink-btn">
                <i class='bx bx-chevron-left'></i>
            </span>
            <img src="imgs/focus (1).png" class="logo" alt="">
            <h3 class="hide">fso</h3>
        </div>

        <div class="search1 wrapp">
            <i class='bx bx-search'></i>
            <input type="text" class="hide" placeholder="Quick Search ...">
        </div>

        <div class="sidebar-links">
            <ul>
                <div class="active-tab"></div>
                <li class="tooltip-element" data-tooltip="0">
                    <a href="index.php" class="active" data-active="0">
                        <div class="icon">
                            <i class='bx bx-home-alt' aria-hidden="true"></i>
                            <i class='bx bxs-home'></i>
                        </div>
                        <span class="link hide">Acceuil</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="1">
                    <a href="stu_choose_semester.php" class="active" data-active="1">
                        <div class="icon">
                            <i class='bx bxs-user-rectangle' aria-hidden="true"></i>
                            <i class='bx bxs-user-account'></i>
                        </div>
                        <span class="link hide">Etudiant</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="2">
                    <a href="message.php" data-active="2">
                        <div class="icon">
                            <i class='bx bx-message-square-detail'></i>
                            <i class='bx bxs-message-square-detail'></i>
                        </div>
                        <span class="link hide">Messages</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="3">
                    <a href="stais_choose_semester.php" data-active="3">
                        <div class="icon">
                            <i class='bx bx-bar-chart-square'></i>
                            <i class='bx bxs-bar-chart-square'></i>
                        </div>
                        <span class="link hide">Rapports et Statistics</span>
                    </a>
                </li>
                <!-- <div class="tooltip">
                    <span class="show">Acceuil</span>
                    <span>Etudiants</span>
                    <span>Messages</span>
                    <span>Rapports et Statistics</span>
                </div> -->
            </ul>
            <h4 class="hide">Shortcuts</h4>
            <ul>
                <li class="tooltip-element" data-tooltip="0">
                    <a href="qr_choose_semester.php" data-active="4">
                        <div class="icon">
                            <i class='bx bx-qr'></i>
                            <i class='bx bx-qr bx-rotate-270'></i>
                        </div>
                        <span class="link hide">Generer le code QR</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="1">
                    <a href="file_choose_semester.php" data-active="5">
                        <div class="icon">
                            <i class='bx bx-add-to-queue'></i>
                            <i class='bx bxs-add-to-queue'></i>
                        </div>
                        <span class="link hide">Nouveau fichier</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="2">
                    <a href="arch_choose_semester.php" data-active="6">
                        <div class="icon">
                            <i class='bx bx-archive'></i>
                            <i class='bx bxs-archive'></i>
                        </div>
                        <span class="link hide">Archive</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="3">
                    <a href="settings.php" data-active="7">
                        <div class="icon">
                            <i class='bx bx-cog'></i>
                            <i class='bx bxs-cog'></i>
                        </div>
                        <span class="link hide">Paramètres</span>
                    </a>
                </li>
                <!-- <div class="tooltip">
                    <span class="show">Generer le code Qr</span>
                    <span>Inserer un nouveau fichier</span>
                    <span>Archive</span>
                    <span>Settings</span>
                </div> -->
            </ul>
        </div>


    </nav>
</body>
<!--Sidebar Script-->
<script src="js/app.js"></script>
<!-- JQUERY -->
<script src="js/jquery.min.js"></script>

<!-- Start Script de confirmationde la supression -->
<!-- End Script de confirmationde la supression -->
<!-- <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script> -->
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>