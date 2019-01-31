<?php 
	include 'header.php'; 
?>

	<!-- Container background transparent 40% -->
    <div class="grid-x grid-padding-x align-spaced">

        <!-- Form -->
        <!-- <div class="cell medium-4 medium-cell-block-y"> -->
        <div>
            <form action="" method="post" id="update-form">
                <div id="intro">
                    <p>Veuillez sélectionner la collection à modifier :</p>
                </div>
                <p class="r_collection">
                <!-- <div id="r_collection"> -->
                    <input type="radio" name="r_ville" id="-_ville">
                    <label for="l_ville">Ville</label>
                    <input type="radio" name="r_dept" id="r_dept">
                    <label for="l_dept">Département</label>
                    <input type="radio" name="r_region" id="r_region">
                    <label for="l_region">Région</label>
                
                <!-- </div> -->
                </p>

                <p class="data_rech">
                    <label for="label_data">Saisir votre recherche</label>
                    <input type="data" name="data_rech" id="data_rech" size="33<" placeholder="saisir nom ville ou département ou région">
                </p>

                <!-- <button class="hollow button rounded bordered" type="submit" href="#">Envoyez</button> -->
                <input type="submit" value="envoyer" name="recherche">

                <?php


                $flag_ville  = 0;
                $flag_dept   = 0;
                $flag_region = 0;

                 // select collection 
                if (!isset($_POST['r_ville']) && !isset($_POST['r_dept']) && !isset($_POST['r_region'])) :
                    echo "Sélectionner au moins une collection.";
                else :

                    // flag collection
                    if (isset($_POST['r_ville']) && !isset($_POST['r_dept']) && !isset($_POST['r_region'])) :
                        $flag_ville = 1;
                    else:
                        if (!isset($_POST['r_ville']) && isset($_POST['r_dept']) && !isset($_POST['r_region'])) :
                            $flag_dept = 1;
                        else :
                            if (!isset($_POST['r_ville']) && !isset($_POST['r_dept']) && isset($_POST['r_region'])) :
                                $flag_region = 1;
                                else :
                                    echo "Sélectionner une seule collection.";
                            endif;    
                        endif;
                    endif;
                endif;

                 // select data 
                if (isset($_POST['data_rech'])) :

                    // get attribut collection
                    $data_rech    = htmlspecialchars($_POST['data_rech']);
                                                
                    // get data from collection
                                    
                    $filter = [
                        'nom' => $data_rech
                    ];

                    // Check ville /département/région: 
                    $query             = new MongoDB\Driver\Query($filter);

                    if( $flag_ville == 1 ) : 
                            $result    = $manager->executeQuery($db . '.villes', $query);
                    else :
                        if( $flag_dept == 1 ) :
                            $result    = $manager->executeQuery($db . '.departements', $query);
                        else :
                            $result    = $manager->executeQuery($db . '.region', $query);    
                        endif;
                    endif;

                    $data_collection = current($result->toArray());

                    print_r($data_collection);

                else :
                    // display error 
                    echo "Formulaire incomplet";
                endif;
                    
                

                // $db->villes->find(array("cp" => $update_cp), array("cp" => 1, "pop" => 1));

                // $bulk = new MongoDB\Driver\BulkWrite;
                // $bulk->update(
                // ['cp' => $update_cp],
                // ['$set' => ['y' => 3]],
                // ['multi' => false, 'upsert' => false]
                // );

                // $result = $manager->executeBulkWrite('db.collection', $bulk);

                ?> 
        
            </form>
        </div>
    </div>


<?php 
	include 'footer.php'; 
?>
