
<?php
include('connection.php');
if (isset($_POST['add-user'])) {
  $apogee = $_POST['apogee'];
  $name = $_POST['name'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['phoneNumber'];
  $dateNai = $_POST['dateNai'];

  $sql = "SELECT * FROM etudiant WHERE Apogee = '$apogee';";
  $res = mysqli_query($connection, $sql);
  if (mysqli_num_rows($res) == 0) { // User does not exist, insert user data into database
    $query = "INSERT INTO etudiant VALUES ('$apogee','$name','$prenom','$email','$phoneNumber','$dateNai');";
    $result = mysqli_query($connection, $query);
    if ($result) {
      header('Location:Etudiants.php');
    }
  } else {
    header('Location:Etudiants.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Espace Etudiant</title>

  <!-- Font Icon -->
  <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

  <!-- Main css -->
  <link rel="stylesheet" href="css/adduserForm.css">
  <link rel="stylesheet" href="css/boxicons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
</head>

<body>

  <div class="main">
    <nav>
      <ul>
        <li>
          <a href="Etudiants.php">Retour</a>
        </li>
      </ul>
    </nav>
    <!-- Sign up form -->
    <section class="signup">
      <div class="container">
        <div class="signup-content">
          <div class="signup-form">
            <h2 class="form-title">Sign up</h2>
            <form method="POST" class="register-form" id="register-form" action="addUser.php">
              <div class="form-group">
                <label for="Apogee"><i class='bx bxs-lock-open-alt'></i></label>
                <input type="text" name="apogee" id="apogee" value="" placeholder="Numero Apogee" required/>
              </div>
              <div class="form-group">
                <label for="name"><i class='bx bxs-user'></i></label>
                <input type="text" name="name" id="name" value="" placeholder="Nom" required/>
              </div>
              <div class="form-group">
                <label for="prenom"><i class='bx bxs-user'></i></label>
                <input type="text" name="prenom" id="prenom" value="" placeholder="Prenom" required/>
              </div>
              <div class="form-group">
                <label for="email"><i class="zmdi zmdi-email"></i></label>
                <input type="email" name="email" id="email" value="" placeholder="Your Email" required/>
              </div>
              <div class="form-group">
                <label for="phoneNumber"><i class='bx bxs-phone'></i></label>
                <input type="number" name="phoneNumber" id="phoneNumber" value="" placeholder="Numero du telephone" required/>
              </div>
              <div class="form-group">
                <label for="dateNai"><i class='bx bxs-baby-carriage'></i></label>
                <input type="date" name="dateNai" id="dateNai" value="" placeholder="Date de naissance" required/>
              </div>
              <div class="form-group">
              </div>
              <div class="form-group form-button">
                <button type="submit" class="test" name="add-user">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                  Submit
                </button>
              </div>
            </form>
          </div>
          <div class="signup-image">
            <figure><img src="imgs/signup-image.jpg" alt="sing up image"></figure>
          </div>
        </div>
      </div>
    </section>

  </div>

  <!-- JS -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>