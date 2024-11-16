<?php
function input_test($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
session_start();
include('connection.php');
?>



<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'mailer/autoload.php';
if (isset($_POST['num_serie'])) {
    $num_serie = input_test(filter_var($_POST['num_serie'],FILTER_SANITIZE_STRING));
    $get_email = mysqli_query($connection, "SELECT * FROM professeur WHERE num_serie = '$num_serie'");
    if ($get_email) {
        $get_email = mysqli_fetch_assoc($get_email);
        $email = $get_email['email'];
        $new_password = rand(854692, 1020000);

        $mail = new PHPMailer();
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'souhaibtissam2001@gmail.com'; //SMTP username
        $mail->Password = 'zvoawklbbcbdcdwu'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to;

        //Content format
        $mail->isHTML(true); //Set email format to HTML
        $mail->CharSet = "UTF-8";
        $mail->setFrom($email, 'med premier');
        $mail->addAddress($email);
        $mail->Subject = 'Nouveau mot de passe';
        $mail->Body = '<b>bonjour cher professeur <br>voila votre nouveau mot de passe:<br></b>' . $new_password . '<b><br>Cordialement</b>';
        $mail->send();

        if ($mail->send() == TRUE) {
            $_SESSION['succ'] = "<strong>Félicitation!</strong> consulter votre adresse e-mail pour savoir votre nouveau mot de passe ";
        } else {
            $_SESSION['error_status'] = "<strong>Erreur!</strong> Ressayer plus tard.";
        }
        $set_new_psswd = mysqli_query($connection, "UPDATE professeur SET password=$new_password where num_serie = '$num_serie'");
        if ($set_new_psswd) {
            header('Location:adminLogin.php');
            die();
        }
    } else {
        $_SESSION['error_status'] = "<strong>Erreur!</strong> Ressayer plus tard.";
        header('Location:adminLogin.php');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Espace Professeur</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">


    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto|Varela+Round'>
    <link rel='stylesheet' href='css/bootstrap/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel='stylesheet' href='css/bootstrap/font-awesome.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="main">
        <nav>
            <ul>
                <li>
                    <a href="index.php">Retour</a>
                </li>
            </ul>
        </nav>
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">S'authentifier</h2>
                        <form method="POST" class="register-form" id="register-form" action="login.php">
                            <div class="">
                                <div class="input-group mb-16">
                                    <?php
                                    if (isset($_SESSION['succ']) && $_SESSION['succ'] != "") {
                                        ?>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <?php echo $_SESSION['succ']; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php
                                        unset($_SESSION['succ']);
                                    }
                                    if (isset($_SESSION['error_status']) && $_SESSION['error_status'] != "") {
                                        ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?php echo $_SESSION['error_status']; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php
                                        unset($_SESSION['error_status']);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default"><i
                                                class="zmdi zmdi-account material-icons-name"></i></span>
                                    </div>
                                    <input type="text" name="numSerie" id="your_name" placeholder="Votre Login"
                                        class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">
                                            <i class="zmdi zmdi-lock"></i></span>
                                    </div>
                                    <input type="password" name="CIN" id="password" placeholder="Mot de passe"
                                        class="form-control border-0" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" required />
                                    <div class="input-group-append ">
                                        <span class="input-group-text border border-end "
                                            onclick="password_show_hide();">
                                            <i class="fas fa-eye eye-icon" id="show_eye"></i>
                                            <!-- <i class="fa-solid fa-face-hand-peeking eye-icon" id="hide_eye"></i> -->
                                            <i class="fas fa-eye-slash d-none eye-icon" id="hide_eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                    me</label>
                            </div>
                            <div class="form-group form-button">
                                <!--<a href="#" class="test" name="submit"></a>

                                <input type="submit" name="submit" class="test" id="submit" value="Submit" />-->
                                <button type="submit" class="test">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    Submit
                                </button><!---->
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link" data-bs-toggle="modal" data-bs-target="#exampleModal">J'ai
                            oublie mon mot de passe</a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Recupérer votre mot de passe
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <Form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <div class="modal-body">
                                            <p class="py-2">
                                                entrez votre Numéro de Série pour vous envoyer un nouveau mot de passe :
                                            </p>
                                            <div class="form-outline">
                                                <input id="typeEmail" class="form-control my-3" name="num_serie"
                                                    placeholder="Numéro de Série" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Soumettre</button>
                                        </div>
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="js/main.js"></script>
    <script>
        function password_show_hide() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>