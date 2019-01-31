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

            <!-- Name input -->
            <div class="cell">
                <label for="data_rech">Saisir votre recherche</label>
                <input type="text" name="data_rech" id="data_rech" size="33<" placeholder="saisir nom ville ou département ou région">
            </div>

            <!-- Submit button-->
            <div class="cell">
                <input type="submit" value="envoyer" name="recherche">
            </div>
        </form>

        <!-- Operational Table -->
        <div class="medium-8 cell">
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
                                <tr>
                                    <th>Nom</th>
                                    <th>Code postal</th>
                                    <th>Population</th>                        
                                </tr>
                            </thead>
                            <tbody>

                            <?php                       
                            foreach ($result as $document) {   
                            ?>

                                <tr>
                                    <td><?php echo $document->nom;  ?></td>
                                    <td><?php echo $document->cp;  ?></td>           
                                    <td><?php echo $document->pop;  ?></td>
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
                                    <tr>
                                        <th>Nom</th>
                                        <th>Appartenance au Région</th>                      
                                    </tr>
                                </thead>
                                <tbody>

                                <?php                       
                                foreach ($result as $document) {   
                                ?>

                                    <tr>
                                        <td><?php echo $document->nom;  ?></td>         
                                        <td><?php echo $document->_id_region;  ?></td>
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
                                    <tr>
                                        <th>Nom</th>                   
                                    </tr>
                                </thead>
                                <tbody>

                                <?php                       
                                foreach ($result as $document) {   
                                ?>

                                    <tr>
                                        <td><?php echo $document->nom;  ?></td>         
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

                    // $db->villes->find(array("cp" => $update_cp), array("cp" => 1, "pop" => 1));

                    // $bulk = new MongoDB\Driver\BulkWrite;
                    // $bulk->update(
                    // ['cp' => $update_cp],
                    // ['$set' => ['y' => 3]],
                    // ['multi' => false, 'upsert' => false]
                    // );

                    // $result = $manager->executeBulkWrite('db.collection', $bulk);
                
                endif;
                ?>                     
            </table>
        </div>       
    </div>


<?php 
	include 'footer.php'; 
?>