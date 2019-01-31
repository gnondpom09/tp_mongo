<?php 
	include 'header.php'; 
?>

		<!-- Container background transparent 40% -->
		<div class="grid-x grid-padding-x align-spaced">

			<!-- Form -->
			<div class="cell medium-4 medium-cell-block-y">
				<form action="" method="get">
					<?php

						//make the inputs
						$filtre = ['ville' => 'Ville *', 
								   'departement' => 'Département', 
								   'region' => 'Région'];

						foreach ($filtre as $key => $value) { 
							$input = '';
							if (isset($_GET['filtre'][$key])) {
								$input = htmlspecialchars($_GET["filtre"][$key]);
							}
							printf('<div class="grid-x grid-padding-x align-spaced">
										<div class="medium-1 cell">
      										<label for="middle-label" class="text-right middle">%s</label>
    									</div>
    									<div class="medium-2 cell">
      										<input type="text" id="middle-label" name="filtre[%s]" value="%s">
   										</div>
									</div>', $value, $key, $input);
						}

						//connection
						include_once 'connexion.php';
						$collname = 'villes';

						/** 
						* set a flag
						* 0 -> no parameters entered or no city matched
						* 1 -> only city name entered or/and only one result	
						* 2	-> (2 or 3 parameters entered (city must be included)) or more than one city have the same name
						*/
						$flag = 0;

						try {
							if ( (isset($_GET['filtre']['ville']) && isset($_GET['filtre']['departement']) && isset($_GET['filtre']['region'])) ) {
								if ($_GET['filtre']['ville'] != '' && $_GET['filtre']['departement'] == '' && $_GET['filtre']['region'] == '') {
									$flag = 1;
									$cityname = htmlspecialchars($_GET['filtre']['ville']);

									//aggregation
									$pipeline_pre = [
										['$match' => ['nom' => $cityname]],
										['$lookup' => ['from' => 'departements',
													   'localField' => '_id_dept',
													   'foreignField' => '_id',
													   'as' => 'dept']],
										['$unwind' => '$dept'],
										['$project' => ['_id' => 0,
														'dept' => ['_id_region' => 1,
																	'nom' => 1],
														'nom' => 1]]];
									$command_pre = new MongoDB\Driver\Command(['aggregate' => $collname, 'pipeline' => $pipeline_pre]);
									$rows_pre = $Connexion -> executeCommand($dbname, $command_pre) -> toArray();
									$results_pre = $rows_pre[0] -> result;

									//verify if the city exists, or there are more than one city have the same name, than change the flag
									if (sizeof($results_pre) > 1) {
										$flag = 2;
										/*controlled by php
										<div class="grid-x grid-padding-x hidden">
											<fieldset class="medium-4 cell">
												<legend>Il faut choisir un département</legend>
												<input type="radio" name="depart" value="Red" required><label for="depart">Red</label>
												<input type="radio" name="depart" value="Blue"><label for="depart">Blue</label>
												<input type="radio" name="depart" value="Yellow"><label for="depart">Yellow</label>
											</fieldset>	
										</div>
										 */
									} elseif (sizeof($results_pre) == 1) {
										$flag = 1;
									} else {
										$flag = -1;
									}
								} elseif ( ($_GET['filtre']['ville'] != '' && $_GET['filtre']['departement'] != '' && $_GET['filtre']['region'] == '') || ($_GET['filtre']['ville'] != '' && $_GET['filtre']['departement'] != '' && $_GET['filtre']['region'] != '') ) {
									$flag = 2;
									$cityname = htmlspecialchars($_GET['filtre']['ville']);
									$deptname = htmlspecialchars($_GET['filtre']['departement']);
								}
							}
						} catch (exception $exep) {
							printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
						}
					?>
					<button class="hollow button rounded bordered" type="submit" href="#">Envoyez</button>
				</form>
			</div>

			<!-- Results -->
			<div class="cell medium-4 medium-cell-block-y">
				<table class="hover">
					<?php
						try {
							if ($flag == 1) {

								//aggragation
								$pipeline_1 = [
									['$match' => ['nom' => $cityname]],
									['$lookup' => ['from' => 'departements',
												   'localField' => '_id_dept',
												   'foreignField' => '_id',
												   'as' => 'dept']],
									['$unwind' => '$dept'],
									['$project' => ['_id' => 0,
													'dept' => ['_id_region' => 1,
																'nom' => 1],
													'nom' => 1,
													'pop' => 1,
													'cp' => 1,
													'lat' => 1,
													'lon' => 1]], 
									['$lookup' => ['from' => 'regions',
												   'localField' => 'dept._id_region',
												   'foreignField' => '_id',
												   'as' => 'reg']],
									['$unwind' => '$reg'],
									['$sort' => ['dept.code' => 1, 'pop' => -1]]
								];
								$command_1 = new MongoDB\Driver\Command(['aggregate' => $collname, 'pipeline' => $pipeline_1]);
								$rows_1 = $Connexion -> executeCommand($dbname, $command_1) -> toArray();

								//already checked once so need a second time
								$results_1 = $rows_1[0] -> result[0];
								foreach ($results_1 as $key => $value) {
									echo "<tr><td>\n";
								    if (gettype($value) === "object") {
								    	printf("%s.nom : %s", $key, $value -> nom);
								    } else {
								    	printf("%s : %s", $key, $value);
								    }
								    echo "</tr></td>\n";
								}
							} elseif ($flag == 2) {
								
								//aggragation
								$pipeline_2 = [
									['$match' => ['nom' => $cityname]],
									['$lookup' => ['from' => 'departements',
												   'localField' => '_id_dept',
												   'foreignField' => '_id',
												   'as' => 'dept']],
									['$unwind' => '$dept'],
									['$project' => ['_id' => 0,
													'dept' => ['_id_region' => 1,
																'nom' => 1],
													'nom' => 1,
													'pop' => 1,
													'cp' => 1,
													'lat' => 1,
													'lon' => 1]], 
									['$match' => ['dept.nom' => $deptname]],
									['$lookup' => ['from' => 'regions',
												   'localField' => 'dept._id_region',
												   'foreignField' => '_id',
												   'as' => 'reg']],
									['$unwind' => '$reg'],
									['$sort' => ['dept.code' => 1, 'pop' => -1]]
								];
								$command_2 = new MongoDB\Driver\Command(['aggregate' => $collname, 'pipeline' => $pipeline_2]);
								$rows_2 = $Connexion -> executeCommand($dbname, $command_2) -> toArray();
								$results_2 = $rows_2[0] -> result;

								//check if have a result
								if (sizeof($results_2) == 1) {
									foreach ($results_2[0] as $key => $value) {
										echo "<tr><td>\n";
									    if (gettype($value) === "object") {
									    	printf("%s.nom : %s", $key, $value -> nom);
									    } else {
									    	printf("%s : %s", $key, $value);
									    }
									    echo "</tr></td>\n";
									}
								} else {
									echo "<tr><td>\nLa ville et le département ne correspondent pas !</tr></td>\n";
								}
							} elseif ($flag == -1) {
								echo "<tr><td>\nLa ville est introuvable !</tr></td>\n";
							}
						} catch (exception $exep) {
							printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
						}
					?>
				</table>
			</div>
		</div>

<?php 
	include 'footer.php'; 
?>