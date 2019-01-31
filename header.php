<?php 
    session_start();

    // Connect to database
    require_once 'connexion.php'; 

    $collectionName = 'users';
    $collection = $db . '.' . $collectionName;
    $url =  $_SERVER['REQUEST_URI'];

    // redirect if user not logged on maiontenance page
    if ($url == '/tp_mongo/maintenance.php') {
        if (isset($_SESSION['user_logged'])) {
            //header("Location : index.php");
            echo $_SESSION['user_logged'];
        } 
    }

    if ($_POST) {
        // login authentication
        if (isset($_POST['login'])) {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {

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
                $res        = $manager->executeQuery($collection, $query);
                $userLogged = current($res->toArray());
                $state = 0;

            } else {
                // display error 
                $state = 5;
            } 
            //header("Location : index.php?state=$state");
        }

        // Regiter new user
        if (isset($_POST['signup'])) {
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repeat'])) {
                // get values of register form
                $pseudo   = htmlspecialchars($_POST['name']);
                $email    = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $repeat   = htmlspecialchars($_POST['repeat']);
                
                // TODO : Check if user exists

                if ($password == $repeat) {
                    // add new user
                    $insertUser = new MongoDB\Driver\BulkWrite;
                    $insertUser->insert([
                        'name' => $pseudo,
                        'email' => $email,
                        'role'  => 'edit',
                        'password' => $password
                    ]);
                    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                    $result = $manager->executeBulkWrite($collection, $insertUser, $writeConcern);
                    if ($result->getInsertedCount()) {
                        // success
                        $state = 4;
                    } else {
                        // display error
                        $state = 2;
                    } 
                } else {
                    // passwords differents
                    $state = 6;
                }
            } else {
                // all fields required
                $state = 5;
            }
            //header("Location: index.php?state=$state");
        }
        //header("Location: index.php?state=$state");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geo France</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.5.1/dist/css/foundation.min.css" integrity="sha256-1mcRjtAxlSjp6XJBgrBeeCORfBp/ppyX4tsvpQVCcpA= sha384-b5S5X654rX3Wo6z5/hnQ4GBmKuIJKMPwrJXn52ypjztlnDK2w9+9hSMBz/asy9Gw sha512-M1VveR2JGzpgWHb0elGqPTltHK3xbvu3Brgjfg4cg5ZNtyyApxw/45yHYsZ/rCVbfoO5MSZxB241wWq642jLtA==" crossorigin="anonymous">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/revealer.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body class="demo-modal">

    <div class="wrapper">

        <header class="site-header">

            <nav id="site-navigation" class="main-navigation">
                <ul class="menu-login">
                    <li class="toggle-login">
                        <?php 

                            // Display message for user logged
                            if (isset($_SESSION['user_logged'])) {
                                // get name of user logged with email and password
                                $filter = [
                                    '_id' => $_SESSION['user_logged']
                                ];
                                // Check if user is in database
                                $query      = new MongoDB\Driver\Query($filter);
                                $res        = $manager->executeQuery($collection, $query);
                                $userLogged = current($res->toArray());
                            } 

                            // Display login of logout button
                            if (!empty($userLogged)) :
                                // Check if user is in database
                                $_SESSION['user_logged'] = $userLogged->_id;
                                echo "Bonjour " . $userLogged->name;
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
            <div class="message"><?= $message ?></div>

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
                        <p class="legend">Pas encore inscrit?</p>
                        <p id="open-register" class="btn btn--modal-register">S'enregister</p>
                    </form>
                </div>
            </div>

            <div class="modal-register">
                <img src="ressources/ldnr_logo.png" alt="logo">
                <div class="modal__inner">
                    <form action="" method="post" id="register-user">
                        <p class="login-name">
                            <label for="email-user">Pseudo</label>
                            <input type="text" name="name" id="pseudo-user" placeholder="Pseudo" >
                        </p>
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
                        <input type="submit" name="signup" value="Créer mon compte">
                    </form>
                </div>
            </div> 

        </header>







    