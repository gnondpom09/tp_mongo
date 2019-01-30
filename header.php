<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geo France</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.1/css/foundation.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/revealer.css">
</head>
<body class="demo-modal">

    <?php 
        
        // Connect to database
        include_once 'connexion.php'; 

    ?>

    <header id="masthead" class="site-header">
        <nav id="site-navigation" class="main-navigation">
            <ul class="menu-login">
                <li class="toggle-login">
                    <button class="btn-login btn--modal-open menu-item">
                        <i class="far fa-user"></i> Connexion
                    </button>
                </li>
            </ul>
        </nav>

        <div class="modal">
            <img src="ressources/ldnr_logo.png" alt="logo">
            <div class="modal__inner">
                <form action="" method="post" id="login-form">
                    <p class="login-email">
                        <label for="email-user">Email</label>
                        <input type="email" name="email" id="email-user" placeholder="Email" >
                    </p>
                    <p class="login-password">
                        <label for="pass-user">Mot de passe</label>
                        <input type="password" name="password" id="pass-user" placeholder="Mot de passe" >
                    </p>
                    <input type="submit" value="Connexion" name="login">
                    <p class="legend">Pas encore inscrit?</p><button class="btn btn--modal-register">S'enregister</button>
                </form>
            </div>
        </div>

        <div class="modal-register">
            <img src="ressources/ldnr_logo.png" alt="logo">
            <div class="modal__inner">
                <form action="" method="post" id="register-user">
                    <p class="login-email">
                        <label for="email-user">Email</label>
                        <input type="email" name="email" id="email-user" placeholder="Email" >
                    </p>
                    <p class="login-password">
                        <label for="pass-user">Mot de passe</label>
                        <input type="password" name="password" id="pass-user" placeholder="Mot de passe" >
                    </p>
                    <p class="login-password">
                        <label for="repeat-password">Mot de passe</label>
                        <input type="password" name="repeat" id="repeat-password" placeholder="Répéter le mot de passe" >
                    </p>
                    <input type="submit" value="Créer mon compte">
                </form>
            </div>
        </div>

    </header>



    