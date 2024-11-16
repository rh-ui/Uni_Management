<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/framework.css" />
    <link rel="stylesheet" href="css/master.css" />
    <link rel="stylesheet" href="css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
    <title>Contact Form - Alert Message</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            width: 700px;
            height: auto;
            background-color: #fff;
            border-radius: 10px;
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
        }

        .box {
            width: 500px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h3 {
            font-size: 35px;
            margin: 15px;
        }

        .name {
            width: 100%;
            position: relative;
            margin-bottom: 15px;
        }

        .name i {
            position: absolute;
            top: 50%;
            left: 30px;
            transform: translateY(-50%);
            font-size: 20px;
            color: #bbb;
        }

        .name input {
            width: 100%;
            padding: 20px 60px;
            border: none;
            outline: none;
            font-size: 18px;
            background-color: #eee;
            border-radius: 40px;
        }

        .name input::placeholder {
            color: #bbb;
            font-weight: 500;
        }

        .email {
            width: 100%;
            position: relative;
            margin-bottom: 15px;
        }

        .email i {
            position: absolute;
            top: 50%;
            left: 30px;
            transform: translateY(-50%);
            font-size: 20px;
            color: #bbb;
        }

        .email input {
            width: 100%;
            padding: 20px 60px;
            border: none;
            outline: none;
            font-size: 18px;
            background-color: #eee;
            border-radius: 40px;
        }

        .email input::placeholder {
            color: #bbb;
            font-weight: 500;
        }

        .message-box {
            width: 100%;
            position: relative;
            margin-bottom: 15px;
        }

        .message-box i {
            position: absolute;
            top: 50%;
            left: 30px;
            transform: translateY(-50%);
            font-size: 20px;
            color: #bbb;
        }

        .message-box textarea {
            width: 100%;
            padding: 20px 60px;
            border: none;
            outline: none;
            font-size: 18px;
            background-color: #eee;
            border-radius: 40px;
        }

        .message-box textarea::placeholder {
            color: #bbb;
            font-weight: 500;
        }

        .button {
            width: 100%;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .button button {
            width: 100%;
            padding: 10px;
            font-size: 20px;
            color: #fff;
            background-color: #084cdf;
            border: none;
            outline: none;
            border-radius: 40px;
            cursor: pointer;
        }

        .message {
            width: 100%;
            position: relative;
            margin-bottom: 60px;
            display: flex;
            justify-content: center;
        }

        .message .success {
            font-size: 20px;
            color: green;
            position: absolute;
            animation: buttons .3s linear;
            display: none;
        }

        .message .danger {
            font-size: 20px;
            color: red;
            position: absolute;
            transition: .3s;
            animation: buttons .3s linear;
            display: none;
        }

        @keyframes buttons {
            0% {
                transform: scale(0.1);
            }

            50% {
                transform: scale(0.5);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <!-- font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>

<body>
    <div class="page d-flex">
        <!-------------------------------------------------Side Bar-------------------------------------------------->
        <?php include('sidebar.php'); ?>
        <!------------------------------------------------------------------------------------------------------->
        <div class="content w-full">


            <!-- Start Head -->
            <div class="head bg-white p-15 between-flex">
                <div class="search">

                </div>
                <div class="icons d-flex align-center">
                    <span class="notification p-relative">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>

                </div>
            </div>
            <!-- End Head -->
            <div class="container">
                <div class="box">
                    <h3>Envoyer message</h3>
                    <div class="name">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Name" id="name">
                    </div>
                    <!-- <div class="email">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Email" id="email">
            </div> -->
                    <div class="message-box">
                        <textarea id="msg" cols="30" rows="10" placeholder="Message"></textarea>
                    </div>
                    <div class="button">
                        <button id="send" onclick="message()">Send</button>
                    </div>
                    <div class="message">
                        <div class="success" id="success">Your Message Successfully Sent!</div>
                        <div class="danger" id="danger">Feilds Can't be Empty!</div>
                    </div>
                </div>
            </div>


            <script>
                function message() {
                    var Name = document.getElementById('name');
                    var email = document.getElementById('email');
                    var msg = document.getElementById('msg');
                    const success = document.getElementById('success');
                    const danger = document.getElementById('danger');

                    if (Name.value === '' || email.value === '' || msg.value === '') {
                        danger.style.display = 'block';
                    }
                    else {
                        setTimeout(() => {
                            Name.value = '';
                            email.value = '';
                            msg.value = '';
                        }, 2000);

                        success.style.display = 'block';
                    }


                    setTimeout(() => {
                        danger.style.display = 'none';
                        success.style.display = 'none';
                    }, 4000);

                }
            </script>
</body>

</html>