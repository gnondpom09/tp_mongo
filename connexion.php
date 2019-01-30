<?php

// Connexion base geo_france

$dsn='mongodb://localhost:27017';
$dbname = 'geo_france';

try {
    
        // connexion base de données
        $Connexion = new MongoDB\Driver\Manager($dsn);  

        // Sélection de la database "geo_france"
         $db = $connexion->selectDB($dbname);
         
   
} catch (exception $exep) {
    printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
  }
  