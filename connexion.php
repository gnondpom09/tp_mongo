<?php

// Connexion base geo_france

$dsn='mongodb://localhost:27017';


try {
        // connexion base de données
        $manager = new \MongoDB\Driver\Manager($dsn);
        $db = "geo_france";
   
} catch (exception $exep) {
    printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
  }
