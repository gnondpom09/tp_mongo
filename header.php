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
    <!-- Compressed CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.5.1/dist/css/foundation.min.css" integrity="sha256-1mcRjtAxlSjp6XJBgrBeeCORfBp/ppyX4tsvpQVCcpA= sha384-b5S5X654rX3Wo6z5/hnQ4GBmKuIJKMPwrJXn52ypjztlnDK2w9+9hSMBz/asy9Gw sha512-M1VveR2JGzpgWHb0elGqPTltHK3xbvu3Brgjfg4cg5ZNtyyApxw/45yHYsZ/rCVbfoO5MSZxB241wWq642jLtA==" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.1/css/foundation.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/revealer.css">
</head>
<body class="demo-modal">

    <header id="masthead" class="site-header">

        <nav id="site-navigation" class="main-navigation">
            <ul class="menu-login">
                <li class="toggle-login">
                    <?php 
            
                        // Connect to database
                        //include_once 'connexion.php'; 
                        $manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
                        $db = "geo_france";
                        
                        if (isset($_SESSION['user_logged'])) {
                            // get name of user logged with email and password
                            $filter = [
                                '_id' => $_SESSION['user_logged']
                            ];
                            // Check if user is in database
                            $query      = new MongoDB\Driver\Query($filter);
                            $res        = $manager->executeQuery($db . '.users', $query);
                            $userLogged = current($res->toArray());
                        } 

                        // login authentication
                        if (isset($_POST['login'])) :
                            if (isset($_POST['email']) && isset($_POST['password'])) :

                                // get identifiers
                                $email    = htmlspecialchars($_POST['email']);
                                $password = htmlspecialchars($_POST['password']);
                                
                                // get name of user logged with email and password
                                $filter = [
                                    'email' => $email, 
                                    'password' => $password
                                ];
                                // Check if user is in database
                                $query      = new MongoDB\Driver\Query($filter);
                                $res        = $manager->executeQuery($db . '.users', $query);
                                $userLogged = current($res->toArray());

                            else :
                                // display error 
                                echo "Formulaire incomplet";
                            endif;
                            
                        endif;
                        
                        // Display message for user logged
                        if (!empty($userLogged)) :
                            // Check if user is in database
                            $_SESSION['user_logged'] = $userLogged->_id;
                            echo "Bonjour " . $userLogged->name . " " . $_SESSION['user_logged'];
                            ?>
                            <form action="" method="post">
                                <input type="submit" name="logout" id="logout" class="btn-login menu-item" value="Déconnexion">
                            </form>
                            <?php
                        else :
                            echo "Veuillez vous identifier";
                            ?>
                            <button class="btn-login btn--modal-open menu-item">
                                <i class="far fa-user"></i> Connexion
                            </button>
                            <?php
                        endif;

                        // Event logout
                        if (isset($_POST['logout'])) {
                            // logout user
                            unset($_SESSION['user_logged']);
                            $userLogged = null;
                            session_destroy();
                        }
                    
                    ?>
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





    