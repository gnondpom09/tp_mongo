<?php 
	include 'header.php'; 
?>

<!-- Menu -->
<div class="title-bar" data-responsive-toggle="example-animated-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>
<div class="top-bar" id="example-animated-menu" data-animate="hinge-in-from-top hinge-out-from-top">
    <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text">LDNR</li>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Visualisation</a></li>
            <li><a href="#">Maintenance</a></li>
        </ul>
    </div>
</div>

<div class="modal">
    <div class="modal__inner">

        <form action="" method="post" id="update-form">

            <div id="intro">
                <p>Veuillez saisir la collection à modifier :</p>
            </div>

            <div id="buttons_type">
                <button id="maj_ville" type="button" onclick="">ville</button>
                <button id="maj_dept" type="button" onclick="">dept</button>
                <button id="maj_region" type="button" onclick="">region</button>
            </div>

            <p class="ville_recherche">
                <label for="ville_rech">Ville</label>
                <input type="ville" name="ville" id="ville" placeholder="saisir la ville">
            </p>

            <input type="submit" value="Soumettre" name="recherche">





            <!-- recherche ville : -->
            <?php


if (isset($_GET['ville']) )

{

    db.villes.find();
    }

}

else

{

   echo 'Il faut renseigner un nom de ville ou un code département ou un code région !';

}


            $db->villes->find(array("cp" => $update_cp), array("cp" => 1, "pop" => 1));

            ?>


            <!-- mise à jour dans la collection ville : -->

            <?php

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(
    ['cp' => $update_cp],
    ['$set' => ['y' => 3]],
    ['multi' => false, 'upsert' => false]
);

$result = $manager->executeBulkWrite('db.collection', $bulk);

?>


        </form>
    </div>
</div>

<?php 
	include 'footer.php'; 
?>
