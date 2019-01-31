<?php

// Connexion base geo_france

$dsn='mongodb://localhost:27017';


try {
        // connexion base de données
        $manager = new \MongoDB\Driver\Manager($dsn);
        $db = "geo_france";
        

        $messages = array(
                1 => 'Enregistrement supprimé!',
                2 => 'Une erreur est survenue, veuillez réessayer plus tard', 
                3 => 'Enregistrement éffectué avec succès!',
                4 => 'Enregistrement mis à jour', 
                5 => 'Tous les champs sont requis',
                6 => 'Les mots de passe doivent etre identiques'
            );
            $state = (isset($_GET['state'])) ? intval($_GET['state']) : 0 ;
            $message = ($state) ? $messages[$state] : '' ;

   
} catch (exception $exep) {
    printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
  }
