<?php
include('connection.php');
?>
<?php 
                        if(isset($_FILES['file']['name'])){
                            $id_etudiant=$_SESSION['user_id'];
                            $filename = $_FILES['file']['name'];
                            $destination = 'profile/' . $filename;
                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                            $file = $_FILES['file']['tmp_name'];
                            $size = $_FILES['file']['size'];
                            if(file_exists($destination)){
                                   $sql="UPDATE etudiant set profile='$destination' where Apogee=$id_etudiant ";
                                   $result=mysqli_query($connection,$sql);
                                 if($result){
                                    header('Location:profile.php');
                                    die();
                                 }
        
        
                            }
                            else{
                                if(move_uploaded_file($file, $destination)){
                                    $sql="UPDATE etudiant set profile='$destination' where Apogee=$id_etudiant ";
                                    $result=mysqli_query($connection,$sql);                                                  
                                
                                    if($result){
                                        header('Location:profile.php');
                                        die();
                                     }
                                }
                            
                        }
                    }
                        
                        
                        ?>
<!DOCTYPE html>
<html lang="en">

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
  <style>
               .img-account-profile {
  height: 10rem;
}

.rounded-circle {
  border-radius: 50% !important;
}

#card {
  box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 17%);
}

#card .card-header {
  font-weight: 500;
}

.card-header:first-child {
  border-radius: 0.35rem 0.35rem 0 0;
}

.card-header {
  padding: 1rem 1.35rem;
  margin-bottom: 0;
  background-color: rgba(33, 40, 50, 0.03);
  border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.file  {
  position: relative;
  overflow: hidden;
}
.myfile {
  position: absolute;
  font-size: 50px;
  opacity: 0;
  right: 0;
  top: 0;
}
  </style>
</head>

<body>

  

  <!-------------------------------------------------Side Bar-------------------------------------------------->
  <?php 
  include('sidebar.php'); ?>
  <!------------------------------------------------------------------------------------------------------->
  <div class="page d-flex">
    <div class="content w-full">
      <!-- Start Head -->
     
            <!-- Start Head -->
            <?php include('head.php') ?>
              <!-- End Head -->
              <div class="container-fluid p-20 rad-10 m-20">
                <div class="mb-25">
                    <div class="row ">
                        <div class="col-xl-4 col-md-6">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0 " id='card'>
                                <div class="card-header text-center">Photo de profile</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <?php
                                                                     $id_etudiant=$_SESSION['user_id'];
                                                                     $sql="SELECT * from etudiant where Apogee=$id_etudiant";
                                                                     $result=mysqli_query($connection,$sql);
                                                                     $row=mysqli_fetch_assoc($result)
                                                                     
                                                                     ?>
                                    <img class="img-account-profile rounded-circle mb-2" src="<?php echo $row['profile']; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG ou PNG (ne depasse pas 5 MB)*
                                    </div>
                                    <!-- Profile picture upload button-->
                                     <form action="#" method="POST" id='form' enctype="multipart/form-data">  
                                   <div class="file btn btn btn-primary">
							         Changer photo
							        <input type="file" name="file" class="myfile" id="myfile" />
						           </div>
                                   </form> 
                                </div>
                            </div>
                        </div>
                        <script>
                           document.getElementById('myfile').onchange=function(){
                            document.getElementById('form').submit();
                           }
                            
                        </script>
                      
                        
                       
                       
                       
                       
                        <div class="col-xl-8 col-md-6">
                            <!-- Account details card-->
                            <div class="card mb-4" id='card'>
                                <div class="mb-12">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"  role="presentation" class="active"><a
                                                class="nav-link active" href="#home" aria-controls="home" role="tab"
                                                data-toggle="tab">Profile</a></li>
                                        <li class="nav-item" data-bs-target="#profile" role="presentation">
                                            <a class="nav-link" href="#profile"
                                                aria-controls="profile" role="tab" data-toggle="tab">Changer mot de
                                                passe
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="p-20 mt-10 txt-center">
                                    <div class="col-md-16">
                                        <div class="col-md-12">
                                            <div class="portlet dark bordered">
                                                <div class="portlet-body">
                                                    <div>
                                                        <ul class="justify-content-end">
                                                            <!-- Tab panes -->
                                                            <div class="tab-content text-start">
                                                                <div role="tabpanel" class="tab-pane fade show active"
                                                                    id="home" aria-label="home">
                                                                      
                                                                    <?php
                                                                    if (isset($_SESSION['succ_status']) && $_SESSION['succ_status'] != " ") {
                                                                        ?>
                                                                        <div class="alert alert-primary alert-dismissible fade show"
                                                                            role="alert" id="alert1">
                                                                            <?php echo $_SESSION['succ_status']; ?>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="alert" aria-label="Close"
                                                                                data-bs-target="alert1"></button>
                                                                        </div>
                                                                        <?php
                                                                        unset($_SESSION['succ_status']);
                                                                    }
                                                                    if (isset($_SESSION['error_status']) && $_SESSION['error_status'] != "") {
                                                                        ?>
                                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                                            role="alert">
                                                                            <?php echo $_SESSION['error_status']; ?>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="alert"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <?php
                                                                        unset($_SESSION['error_status']);
                                                                    }
                                                                    ?>
                                                                   
                                                                     <?php
                                                                     $id_etudiant=$_SESSION['user_id'];
                                                                     $sql="SELECT * from etudiant where Apogee=$id_etudiant";
                                                                     $result=mysqli_query($connection,$sql);
                                                                     while($row=mysqli_fetch_assoc($result)){
                                                                     
                                                                     ?>
                                                                            <form id="form_update" action="#" method="post">
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20"
                                                                                            for="nom">Nom</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="name"
                                                                                                value="<?php echo $row['nom']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20"
                                                                                            for="nom">Prenom</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="prenom"
                                                                                                value="<?php echo $row['prenom']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label class="txt-c-mobile fs-20">Numero
                                                                                             Apogee</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="numApogee"
                                                                                                value="<?php echo $row['Apogee']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">CIN</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="cin"
                                                                                                value="<?php echo $row['cin']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Adresse
                                                                                            E-mail</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="email"
                                                                                                value="<?php echo $row['email']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-6 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Téléphone</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control modify"
                                                                                                name="phone"
                                                                                                value="<?php echo $row['telephone']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='form-row'>
                                                                                    <div class='col-md-4 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Genre</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="grade"
                                                                                                value="<?php echo $row['genre']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class='col-md-4 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">Groupe</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="nomModule"
                                                                                                value="<?php echo $row['id_groupe']?>"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                    <div class='col-md-4 mb-3'>
                                                                                        <label
                                                                                            class="txt-c-mobile fs-20">pays</label>
                                                                                        <div class='input-group'>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="input_form" name="nomDep"
                                                                                                value="Maroc"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='px-2 d-flex flex-row-reverse'>
                                                                                    <button name="profil-update-btn"
                                                                                        class="btn btn-primary"
                                                                                        id="form-update-btn">Modifier</button>
                                                                                    <?php
                                                                                    if (isset($_POST['profil-update-btn'])) {
                                                                                        ?>
                                                                                        <div class="px-2">
                                                                                            <button type="submit" name="save"
                                                                                                class="btn btn-primary ">Sauvegarder
                                                                                            </button>
                                                                                    </div>
                                                                                        <script>
                                                                                            const form_update = document.getElementById('form_update');
                                                                                            form_update.action = "updatee.php";
                                                                                            const update_btn = document.getElementById('form-update-btn');
                                                                                            update_btn.innerHTML = "ignorer";
                                                                                            update_btn.classList.replace("btn-primary", "btn-secondary");
                                                                                            var inputs = document.getElementsByClassName("modify");
                                                                                            for (var i = 0; i < inputs.length; i++) {
                                                                                                inputs[i].disabled = false;
                                                                                            }
                                                                                        </script>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                         
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade" aria-label="profile" id="profile">
                                                            <?php
                                                                if (isset($_SESSION['pass_succ_status']) && $_SESSION['pass_succ_status'] != "") {
                                                                    ?>
                                                                    <div class="alert alert-primary alert-dismissible fade show"
                                                                        role="alert">
                                                                        <?php echo $_SESSION['pass_succ_status']; ?>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="alert"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <?php
                                                                    unset($_SESSION['pass_succ_status']);
                                                                }
                                                                if (isset($_SESSION['pass_error_status']) && $_SESSION['pass_error_status'] != "") {
                                                                    ?>
                                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                                        role="alert">
                                                                        <?php echo $_SESSION['pass_error_status']; ?>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="alert"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <?php
                                                                    unset($_SESSION['pass_error_status']);
                                                                }
                                                                ?>
                                                                
                                                                        <form class='' action='updatee.php' method='post'>
                                                                            <div class='form-row text-dark'>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <label for="password"
                                                                                        class=" floatingInput text-dark">Entrer
                                                                                        votre mot de passe courant :</label>
                                                                                    <div class='input-group'>
                                                                                        <input 
                                                                                            name='ancien_password'
                                                                                            placeholder='Mot de passe courant'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <label for="password"
                                                                                        class=" floatingInput text-danger">changer
                                                                                        votre mot de passe :</label>
                                                                                    <div class='input-group'>
                                                                                        <input type='password'
                                                                                            name='1_new_password'
                                                                                            placeholder='Nouveau mot de passe'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class='col-md-12 mb-3'>
                                                                                    <div class='input-group'>
                                                                                        <input type='password'
                                                                                            name='2_new_password'
                                                                                            placeholder='Retapez le nouveau mot de passe'
                                                                                            class='form-control'
                                                                                            aria-describedby='inputGroupPrepend'
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class='pt-10 pl-95'>
                                                                                <button class='btn btn-primary' type='submit'
                                                                                    name='admin-update'>Sauvegarder</button>
                                                                            </div>
                                                                        </form>
                                                                   
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
     
        

      
  <!--Sidebar Script-->
      <!-- JQUERY -->
        <!--Sidebar Script-->
        <script src=" js/app.js"></script>
        <!-- JQUERY -->
<script src="js/jquery.min.js"></script>
        <!-- JS -->

        
        <!-- <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script> -->
<script src='js/popper.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
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

        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       
</body>

</html>