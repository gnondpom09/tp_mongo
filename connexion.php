<?php

// Connexion base geo_france

$dsn='mongodb://localhost:27017';
$dbname = 'geo_france';

try {
    
        // connexion base de données
        $Connexion = new MongoDB\Driver\Manager($dsn);  
   
} catch (exception $exep) {
    printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
  }
  