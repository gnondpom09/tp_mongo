<?php 
	include 'header.php'; 
?>

<!-- Menu -->
<div class="title-bar" data-responsive-toggle="example-animated-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="maint">
    <div class="maint_update">

        <form action="" method="post" id="update-form">

            <div id="intro">
                <p>Veuillez saisir la collection à modifier :</p>
            </div>

            <div id="r_collection">
                <label for="l_ville">Ville</label>
                <input type="radio" name="r_ville" id="-_ville">
                <label for="l_dept">Département</label>
                <input type="radio" name="r_dept" id="r_dept">
                <label for="l_region"Région></label>
                <input type="radio" name="r_region" id="r_region">
            </div>

            <p class="ville_recherche">
                <label for="ville_rech">Ville</label>
                <input type="ville" name="ville" id="ville" placeholder="saisir la ville">
            </p>

            <input type="submit" value="Soumettre" name="recherche">





            <!-- recherche ville : -->
            <?php


    // if (isset($_POST['ville']) )
    // {
        
    //     }
    // else
    // {

    // echo 'Il faut renseigner un nom de ville ou un code département ou un code région !';

    // }

    //             $db->villes->find(array("cp" => $update_cp), array("cp" => 1, "pop" => 1));

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
