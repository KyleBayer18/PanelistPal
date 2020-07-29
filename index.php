<?php
include "./header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["ERROR"] = "";
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $content = trim($_POST["message"]);

    $message = "<!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>Document</title>
                                <style>
                            :root {
                                --primary: #ddd;
                                --dark: #333;
                                --light: #FFF;
                                --shadow: 0 1px 5px rgba(104, 104, 104, 0.8);
                            }

                            html {
                                box-sizing: border-box;
                                font-family: Arial, Helvetica, sans-serif;
                                color: var(--dark);
                            }

                            body {
                                background: #ccc;
                                margin: 30px 50px;
                                line-height: 1.4;
                            }

                            .btn{
                                background-color: var(--dark);
                                color: var(--light);
                                padding: 0.6rem 1.3rem;
                                text-decoration: none;
                                border: 0;
                            }

                            img {
                                max-width: 100%;
                            }

                            .wrapper {
                                display: grid;
                                grid-gap: 20px;
                            }

                            .info {
                                background: var(--primary);
                                box-shadow: var(--shadow);
                                display: grid;
                                grid-gap: 5px;
                                grid-template-columns: repeat(2, 1fr);
                                padding: 1rem;
                            }
                                </style>
                            </head>
                            <body>
                                <div class='wrapper'>
                                    <!-- info section -->
                                    <div>
                                        <h2>$email : $subject</h2>
                                        <p>$content</p>
                                    </div>
                                </div>
                            </body>
                            </html>";

    $headers = "From: no-reply@easy-crpc.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if ($email != "" && $subject != "" && $message != "") {
        $a = mail('easycrpc@gmail.com', 'Customer Inquiry', $message, $headers);

        if ($a) {
            $_SESSION["ERROR"] = "Email has been sent!";
        } else {
            $_SESSION["ERROR"] = "Email not sent.";
        }
    }
}

?>

    <!-- Top Container -->
    <section class="top-container">
        <header class="showcase">
            <h1>Expo Evaluator</h1>
            <p>Quickly and easily give your valued feedback!</p>
            <a href="./join.php" class="btn" data-toggle="" data-target="">Find an Event</a>
            <!--POP UP-->
        </header>
    </section>

    <!-- boxes section -->
    <section class="boxes">
        <div class="box one">
            <i class="fas fa-chart-pie fa-4x"></i>
            <h3>Anallytics</h3>
            <p>Your input will be used to help improve learning experiences at Durham College.</p>
        </div>
        <div class="box one">
            <i class="fas fa-smile-beam fa-4x"></i>
            <h3>Easy Process</h3>
            <p>Finding your survery and completing it can take less than two minutes!</p>
        </div>
        <div class="box one">
            <i class="fas fa-users fa-4x"></i>
            <h3>Annonymous</h3>
            <p>All surverys can be submitted annonymously allowing you complete privacy!</p>
        </div>
    </section>



 <?php
include "./footer.php";
?>