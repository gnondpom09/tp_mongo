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
                    <p>Veuillez saisir la collection à modifier :</p>
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
                    <label for="label_data">Zonde de recherche</label>
                    <input type="data" name="data_rech" id="data_rech" placeholder="saisir votre recherche">
                </p>

                <!-- <input type="submit" value="Soumettre" name="recherche"> -->

                <button class="hollow button rounded bordered" type="submit" href="#">Envoyez</button>
                 

                
                <!-- // require_once('config.php');
                // $flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
                // $message ='';
                // if($flag){
                // $message = $messages[$flag];
                // }
                // $filter = [];
                // $options = [
                //     'sort' => ['_id' => -1],
                // ];
                // $query = new MongoDB\Driver\Query($filter, $options);
                // $cursor = $manager->executeQuery('onlinestore.products', $query);
                
                // if (isset($_POST['ville']) )
                // { -->
    
                <!-- //     }
                // else
                // {

                // echo 'Il faut renseigner un nom de ville ou un code département ou un code région !';

                // }

                // $db->villes->find(array("cp" => $update_cp), array("cp" => 1, "pop" => 1));

                // $bulk = new MongoDB\Driver\BulkWrite;
                // $bulk->update(
                // ['cp' => $update_cp],
                // ['$set' => ['y' => 3]],
                // ['multi' => false, 'upsert' => false]
                // );

                // $result = $manager->executeBulkWrite('db.collection', $bulk);

                ?> -->


             
        

        
    
            </form>
        </div>
    </div>


<?php 
	include 'footer.php'; 
?>
