<?php 
	include 'header.php'; 
?>

		<!-- Container background transparent 40% -->
		<div class="grid-x grid-padding-x align-spaced" id="center-container">

			<!-- Form -->
			<div class="cell medium-3 medium-cell-block-y" id="form-container">
				<form action="" method="get" id="visu-form">
					<?php

						//make the inputs
						$filtre = ['ville' => 'Nom Ville*', 
								   'departement' => 'Nom Département', 
								   'region' => 'Nom Région'];

						foreach ($filtre as $key => $value) { 
							$input = '';
							if (isset($_GET['filtre'][$key])) {
								$input = htmlspecialchars($_GET["filtre"][$key]);
							}
							printf('<div class="grid-x grid-padding-x align-spaced">
										<div class="medium-4 cell">
      										<label for="filtre-label" class="text-center middle">%s</label>
    									</div>
    									<div class="medium-7 cell">
      										<input type="text" id="filtre-label" name="filtre[%s]" value="%s">
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
								if ( ($_GET['filtre']['ville'] != '' && $_GET['filtre']['departement'] == '' && $_GET['filtre']['region'] == '') || ($_GET['filtre']['ville'] != '' && $_GET['filtre']['departement'] == '' && $_GET['filtre']['region'] !== '') ){
									$flag = 1;
									$cityname = htmlspecialchars($_GET['filtre']['ville']);

									//aggregation
									$pipeline_pre = [
										['$match' => ['nom' => new MongoDB\BSON\Regex('^'.$cityname.'$','i')]],
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
									$rows_pre = $manager -> executeCommand($db, $command_pre) -> toArray();
									$results_pre = $rows_pre[0] -> result;

									//verify if the city exists, or there are more than one city have the same name, than change the flag
									if (sizeof($results_pre) > 1) {
										$flag = 2;

										//list out the dept available
										printf('<div class="grid-x grid-padding-x align-center">
													<fieldset class="medium-11 cell">
														<legend>Choix de département</legend>');
										foreach ($results_pre as $key => $value) {
											$deptname_pre = $value -> dept -> nom;
											printf('<input type="radio" name="depart" value="%s"><label for="depart">%s</label>', $deptname_pre, $deptname_pre);

										}
										printf('</fieldset>
											</div>');
										if (isset($_GET['depart'])) {
											$deptname = htmlspecialchars($_GET['depart']);
										}

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
					<div class="grid-x grid-padding-x align-center">
						<input type="submit" name="check">
					</div>
				</form>
			</div>

			<!-- Results -->
			<div class="cell medium-3 medium-cell-block-y" id="table-container">
				<table class="hover" id="visu-table">
					<?php
						try {

							//Search with the city name
							if ($flag == 1) {

								//aggragation
								$pipeline_1 = [
									['$match' => ['nom' => new MongoDB\BSON\Regex('^'.$cityname.'$','i')]],
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
								$rows_1 = $manager -> executeCommand($db, $command_1) -> toArray();

								//already checked once so dosen't need a second time
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

								//variable for svg
								$deptname = $results_1 -> dept -> nom;

							} elseif ($flag == 2 && isset($deptname)) {
							//search with the city name && dept name
								//aggragation
								$pipeline_2 = [
									['$match' => ['nom' => new MongoDB\BSON\Regex('^'.$cityname.'$','i')]],
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
									['$match' => ['dept.nom' => new MongoDB\BSON\Regex('^'.$deptname.'$','i')]],
									['$lookup' => ['from' => 'regions',
												   'localField' => 'dept._id_region',
												   'foreignField' => '_id',
												   'as' => 'reg']],
									['$unwind' => '$reg'],
									['$sort' => ['dept.code' => 1, 'pop' => -1]]
								];
								$command_2 = new MongoDB\Driver\Command(['aggregate' => $collname, 'pipeline' => $pipeline_2]);
								$rows_2 = $manager -> executeCommand($db, $command_2) -> toArray();
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

			<!-- SVG Map-->
			<div class="cell medium-3 medium-cell-block-y" id="table-container">
				<?php
				//Function to draw svg img
					function drawSVG($manager, $db, $cityname, $deptname) {
					  //Main pojection function which to lon&lat to x&y
					    function projection($lon, $lat) {
					      return [RATIO*($lon+TX)*cos(LAT_MOY*(M_PI / 180)), RATIO*(-$lat+TY)];
					    }
					     
					    //Creation of some variables
					    //$height will also decides the ratio of zoom
					    $height = 500; 
					    $svgheader = <<<EOSVGH
					    <svg xmlns="http://www.w3.org/2000/svg"
					         viewBox="0 0 %s %s"
					         style="background:#fff">
					        <style>
					            polygon {
					              fill:#519af0;
					            }
					            polygon:hover {
					              fill:#f679e7;
					            }
					            g circle {
					              fill:#fff;
					              fill-opacity:1
					            }
					            g:hover circle {
					              fill:#f679e7;
					              fill-opacity:1
					            }
					            g text {
					              fill:#fff;
					              font-size:20px;
					              opacity:1;
					              alignment-baseline:middle;
					              text-anchor:middle
					            }
					            g:hover text {
					              fill:#f679e7;
					              font-weight:bold;
					            }
					        </style>
EOSVGH;
					    $svgfooter = '</svg>';

					    //Get the border of svg box with map/reduce
					    $map = <<<EOMAP
					    function() {
					      var res = {
					        minlon: 180,
					        maxlon: -180,
					        minlat: 90,
					        maxlat: -90
					      }
					      for (i=0; i<this.contours.length; i++) {
					        for (j=0; j<this.contours[i].length; j++) {
					          if (res.minlon > this.contours[i][j][0]) res.minlon = this.contours[i][j][0];
					          if (res.maxlon < this.contours[i][j][0]) res.maxlon = this.contours[i][j][0];
					          if (res.minlat > this.contours[i][j][1]) res.minlat = this.contours[i][j][1];
					          if (res.maxlat < this.contours[i][j][1]) res.maxlat = this.contours[i][j][1];
					        }
					      }
					      emit(1, res);
					    }
EOMAP;
					    $reduce = <<<EORED
					    function(key, vals) {
					      var res = {
					        minlon: 180,
					        maxlon: -180,
					        minlat: 90,
					        maxlat: -90
					      }
					      vals.forEach(function(val) {
					        if (res.minlon > val.minlon) res.minlon = val.minlon;
					        if (res.maxlon < val.maxlon) res.maxlon = val.maxlon;
					        if (res.minlat > val.minlat) res.minlat = val.minlat;
					        if (res.maxlat < val.maxlat) res.maxlat = val.maxlat;
					      });
					      return {minmax: res};
					    }
EORED;
					    $boxCmd = new MongoDB\Driver\Command([
					      'mapreduce' => 'departements',
					      'map' => $map,
					      'reduce' => $reduce,
					      'query' => ['nom' => new MongoDB\BSON\Regex('^'.$deptname.'$','i'),
					                  'contours' => ['$exists' => true]],
					      'out' => ['inline' => 1]]);
					    $box = $manager->executeCommand($db, $boxCmd)->toArray()[0];

					    //Turn $box to array with json_code
					    $minmax = json_decode(json_encode($box->results[0]->value),true);

					    //Creation of constants
					    define('RATIO', $height/($minmax["maxlat"] - $minmax["minlat"]));
					    define('LAT_MOY', ($minmax["maxlat"] + $minmax["minlat"])/2);
					    define('TX', -$minmax["minlon"]);
					    define('TY', $minmax["maxlat"]);
					    list($width,$unused) = projection($minmax["maxlon"], LAT_MOY);

					    //Begin to draw our svg map
					    printf($svgheader, $width, $height);

					    //Draw the department 
					    $filter = ['nom' =>  new MongoDB\BSON\Regex('^'.$deptname.'$','i'),
					               'contours' => ['$exists' => true]];
					    $options = [
					      'projection' => ['contours' => 1, '_id_region' => 1, '_id' => 0],
					      'sort'       => ['contours' => 1],
					    ];
					     
					    $query = new MongoDB\Driver\Query($filter, $options);
					    $curseur = $manager->executeQuery($db.'.departements', $query);
					     
					    foreach($curseur as $crs) {
					      foreach ($crs->contours as $contour) {
					        printf('<polygon points="'."\n");
					        foreach ($contour as $ptb) {
					          list($lon, $lat) = $ptb;
					          list($px, $py) = projection($lon, $lat);
					          printf(' %d %d', $px, $py);
					        }
					        echo '"/>'."\n";
					      }
					    }

					    //Draw the city
					    $command = new MongoDB\Driver\Command(
					      ['aggregate' => 'villes',
					       'pipeline'=> [['$match' => ['nom' => new MongoDB\BSON\Regex('^'.$cityname.'$','i')]]],
					       'cursor' => ['batchSize' => 10000]]);           
					    $city = $manager->executeCommand($db, $command)->toArray();
					    foreach($city as $doc) {
					      list($px, $py) = projection($doc->lon, $doc->lat);
					      printf('<g><circle cx="%d" cy="%d" r="5"/>'."\n", $px, $py);
					      printf('<text x="%d" y="%d">%s</text></g>'."\n", $px, $py-15, $doc->nom);
					    }
					    //End of svg
					    echo $svgfooter;
					}

					try {
						//verify if inputs are completed
						if ($flag != 0 && isset($deptname)) {
							//Draw svg
							drawSVG($manager, $db, $cityname, $deptname);
						}
					} catch (exception $exep) {
						printf("<p>Erreur : %s</p>\n", htmlspecialchars($exep->getMessage()));
					}

				?>
			</div>
		</div>

<?php 
	include 'footer.php'; 
?>