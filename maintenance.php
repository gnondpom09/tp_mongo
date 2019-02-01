<?php 
	include 'header.php'; 
?>

	<!-- Container background transparent 40% -->
    <div class="grid-x grid-padding-x align-spaced" id="form_maint">

        <!-- Form -->
        <!-- <div class="cell medium-4 medium-cell-block-y"> -->
        <div>
            <form action="" method="post" id="update-form">

                <div id="intro">
                    <p>Veuillez sélectionner la collection à modifier :</p>
                </div>

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

                <!-- // <p class="r_collection">
                
                //     <input type="radio" name="data" id="r_ville" value="r_ville">Ville
                //     <input type="radio" name="data" id="r_dept" value="r_dept">Département
                //     <input type="radio" name="data" id="r_region" value="r_region">Région

                // </p> -->

                <p class="data_rech">
                    <label for="label_data">Saisir votre recherche</label>
                    <input type="text" name="data_rech" id="data_rech" size="33<" placeholder="saisir nom ville ou département ou région">
                </p>

                <!-- <button class="hollow button rounded bordered" type="submit" href="#">Envoyez</button> -->
                <input type="submit" value="envoyer" name="recherche">

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
                        $data_rech    = htmlspecialchars($_POST['data_rech']);
                                                
                        // get data from collection
                                    
                        $filter = [
                            'nom' => $data_rech
                        ];
                        
                        // Check ville /département/région: 
                        $query             = new MongoDB\Driver\Query($filter,  ['projection' => ['nom' => 1, 'pop' => 1, 'cp' => 1]]);

                        if( $flag == 1 ) : 
                                $result    = $manager->executeQuery($db . '.villes', $query);
                        else :
                            if( $flag == 2 ) :
                                $result    = $manager->executeQuery($db . '.departements', $query);
                            else :
                                $result    = $manager->executeQuery($db . '.region', $query);    
                            endif;
                        endif;

                     
                        ?>
                        

                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Code postal</th>
                                    <th>Population</th>                        
                                    <th></th>
                                </tr>
                              </thead>

                        <?php 
                      
                        foreach ($result as $document) {   ?>

                        <tr>

        

                        <td><?php echo $document->nom;  ?></td>

                        <td><?php echo $document->cp;  ?></td>        
                        
                        <td><?php echo $document->pop;  ?></td>
                        
                        <td><a class='editlink' data-id=<?php echo $document->nom; ?> 
                                href='javascript:void(0)'>Edit</a> 
                            <!-- <a onClick ='return confirm("Do you want to remove this
                                        record?");' 
                            href='record_delete.php?id=<?php echo $document->nom;  ?>'>Delete</td> -->

                        </tr>

                        <?php 

                        } 

                        ?>

                        </table>

                        <?php

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
        
            </form>
        </div>
    </div>


<?php 
	include 'footer.php'; 
?>
