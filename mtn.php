<?php 
    include 'header.php'; 
?>

    <!-- Container background transparent 40% -->
    <div class="grid-x grid-padding-x align-center">

        <!-- Form -->
        <form  class="medium-8 cell" action="" method="post" id="update-form">

            <!-- Collection choice -->
            <div class="cell" id="intro">
                <legend>Veuillez sélectionner la collection à modifier :</legend> 

                <?php

                    //get the statue of user
                    $userRole = $userLogged -> role;

                    //make the radion choices
                    $r_collection = ['r_ville' => 'Ville',
                                     'r_dept' => 'Département',
                                     'r_region' => 'Région'];

                    foreach ($r_collection as $key => $value) {

                        //now verify thier statue and then decide which radion button will be available
                        if ($key !== 'r_ville' && $userRole == 'edit') {

                           printf('<input type="radio" name="data" id="%s" value="%s" disabled><label for="data">%s</label>', $key, $key, $value);

                        } else {

                           printf('<input type="radio" name="data" id="%s" value="%s"><label for="data">%s</label>', $key, $key, $value);

                        }
                    }                                               
                ?>
            </div>

            <!-- Name input & Submit button -->
            <div class="cell" id="name-research">
                <label for="data_rech">Saisir votre recherche</label>
                <input type="text" name="data_rech" id="data_rech" size="33<" placeholder="saisir nom ville ou département ou région">

                <input type="submit" value="envoyer" name="recherche">
            </div>
        

            <!-- Operational Table -->
            <div class="medium-8 cell" id="table-container">
                <table class='table'>
                    
                    <?php
                    // sélection bouton envoyer
                    if (isset($_POST['recherche'])) :
                        
                        $flag = 0;
                        
                        // collection sélectionnée
                        if (isset($_POST['data'])) :

                            switch ($_POST['data']) {
                                case "r_ville":
                                    $flag= 1; 
                                    break;
                                case "r_dept":
                                    $flag = 2;
                                    break;
                                case "r_region":
                                    $flag = 3;
                                    break;
                            }
                           
                        else :
                            echo "Sélectionner au moins une collection.";                        
                        endif;
                       
                        // Récupération nom                
                        if (!empty($_POST['data_rech']) && $flag > 0) :
                    
                            // get attribut collection
                            $data_rech = htmlspecialchars($_POST['data_rech']);
                                                    
                            // get data from collection
                                        
                            $filter = [
                                'nom' => $data_rech
                            ];
                            
                            // Check ville /département/région: 
                            $query = new MongoDB\Driver\Query($filter);

                            if( $flag == 1 ) : 
                                $result = $manager->executeQuery($db . '.villes', $query);
                                //TODO verify if ville exists
                                ?>

                                <thead>
                                    <tr><!-- add an invisible input for verify the collection-->
                                        <input type="hidden" name="data_collection" value="villes">
                                        <th>Nom</th>
                                        <th>Code postal</th>
                                        <th>Population</th>
                                        <th>Opération</th>                        
                                    </tr>
                                </thead>
                                <tbody id="modif">

                                <?php                       
                                foreach ($result as $document) {   
                                ?>

                                    <tr>
                                        <td><!-- Disabled, only for transmit the name--><input type="text" name="data_nom" value=<?php echo $document->nom;  ?> readonly></td>
                                        <td><input type="text" name="data_cp" value=<?php echo $document->cp;  ?> ></td>           
                                        <td><input type="text" name="data_pop" value=<?php echo $document->pop;  ?> ></td>
                                        <td><input type="submit" value="Validez" name="valider"></td>
                                    </tr>

                                <?php 
                                }
                                ?>

                                </tbody>
                                
                                <?php 
                            else :
                                if( $flag == 2 ) :
                                    $result = $manager->executeQuery($db . '.departements', $query);
                                    //TODO verify if depart exists
                                    ?>

                                    <thead>
                                        <tr><!-- add an invisible input for verify the collection-->
                                            <input type="hidden" name="data_collection" value="departements">
                                            <th>Nom</th>
                                            <th>Appartenance au Région</th>
                                            <th>Opération</th>                       
                                        </tr>
                                    </thead>
                                    <tbody id="modif">

                                    <?php                       
                                    foreach ($result as $document) {   
                                    ?>

                                        <tr>
                                            <td><!-- Disabled, only for transmit the name--><input type="text" name="data_nom" value=<?php echo $document->nom;  ?> readonly></td>         
                                            <td><input type="text" name="data_id" value=<?php echo $document->_id_region;  ?> ></td>
                                            <td><input type="submit" value="Validez" name="valider"></td>
                                        </tr>

                                    <?php 
                                    }
                                    ?>

                                    </tbody>
                                    
                                    <?php                               
                                else :
                                    $result = $manager->executeQuery($db . '.regions', $query);
                                    //TODO verify if region exists 
                                    ?>

                                    <thead>
                                        <tr><!-- add an invisible input for verify the collection-->
                                            <input type="hidden" name="data_collection" value="regions">
                                            <th>Nom</th>
                                            <th>Nom à modifier</th>
                                            <th>Opération</th>                   
                                        </tr>
                                    </thead>
                                    <tbody id="modif">

                                    <?php                       
                                    foreach ($result as $document) {   
                                    ?>

                                        <tr>
                                            <td><!-- Disabled, only for transmit the name--><input type="text" name="data_nom" value=<?php echo $document->nom;  ?> readonly></td>
                                            <td><input type="text" name="data_nom_modif" value=<?php echo $document->nom;  ?> ></td>
                                            <td><input type="submit" value="Validez" name="valider"></td>        
                                        </tr>

                                    <?php 
                                    }
                                    ?>

                                    </tbody>
                                    
                                    <?php                                    
                                endif;
                            endif;
                        else :
                            // display error 
                            if ( $flag !== 0) :
                                echo "Formulaire incomplet";
                            endif;
                        endif;              
                    endif;

                    //  Update **must do this if out of the loop    
                    if (isset($_POST['valider'])) :
                        switch ($_POST['data_collection']) :
                            case 'villes':
                                $bulk= new MongoDB\Driver\BulkWrite;
                                $wc = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 500);
                                $bulk->update(['nom' => $_POST['data_nom']], ['$set' => ['cp' => $_POST['data_cp'], 'pop' => $_POST['data_pop']]]);
                                $result = $manager->executeBulkWrite($db.'.'.$_POST['data_collection'], $bulk, $wc);
                                printf('<span> Merci, votre mise à jour de la ville <em>%s</em> est enregistré: code postaux -> <em>%s</em>, population -> <em>%s</em></span>', $_POST['data_nom'], $_POST['data_cp'], $_POST['data_pop']);
                                break;
                            case 'departements':
                                $bulk = new MongoDB\Driver\BulkWrite;
                                $wc = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 500);
                                $bulk->update(['nom' => $_POST['data_nom']], ['$set' => ['_id_region' => $_POST['data_id']]]);
                                $result = $manager->executeBulkWrite($db.'.'.$_POST['data_collection'], $bulk, $wc);
                                printf('<span> Merci, votre mise à jour du département <em>%s</em> est enregistré: ID Région -> <em>%s</em></span>', $_POST['data_nom'], $_POST['data_id']);
                                break;
                            case 'regions':
                                $bulk = new MongoDB\Driver\BulkWrite;
                                $wc = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 500);
                                $bulk->update(['nom' => $_POST['data_nom']], ['$set' => ['nom' => $_POST['data_nom_modif']]]);
                                $result = $manager->executeBulkWrite($db.'.'.$_POST['data_collection'], $bulk, $wc);
                                printf('<span> Merci, votre mise à jour de la région <em>%s</em> est enregistré: %s -> <em>%s</em></span>', $_POST['data_nom'], $_POST['data_nom'], $_POST['data_nom_modif']);
                                break;
                        endswitch;
                    endif;
                    ?>                     
                </table>
            </div>  
        </form>     
    </div>




<?php 
    include 'footer.php'; 
?>