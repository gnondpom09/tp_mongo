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

		<!-- Container background transparent 40% -->
		<div class="grid-x grid-padding-x align-spaced">
			<!-- Form -->
			<div class="cell medium-4 medium-cell-block-y">
				<form action="" method="get">
					<div class="grid-x grid-padding-x align-spaced">
						<div class="medium-1 cell">
      						<label for="middle-label" class="text-right middle">Ville * :</label>
    					</div>
    					<div class="medium-2 cell">
      						<input type="text" id="middle-label"  name="ville" placeholder="">
   						</div>
					</div>
					<div class="grid-x grid-padding-x align-spaced">
						<div class="medium-1 cell">
      						<label for="middle-label" class="text-right middle">Département</label>
    					</div>
    					<div class="medium-2 cell">
      						<input type="text" id="middle-label" name="departement" placeholder="">
   						</div>
					</div>
					<div class="grid-x grid-padding-x align-spaced">
						<div class="medium-1 cell">
      						<label for="middle-label" class="text-right middle">Région</label>
    					</div>
    					<div class="medium-2 cell">
      						<input type="text" id="middle-label" name="region" placeholder="">
   						</div>
					</div>

					<!-- controlled by php
					<div class="grid-x grid-padding-x hidden">
						<fieldset class="medium-4 cell">
							<legend>Il faut choisir un département</legend>
							<input type="radio" name="depart" value="Red" required><label for="depart">Red</label>
							<input type="radio" name="depart" value="Blue"><label for="depart">Blue</label>
							<input type="radio" name="depart" value="Yellow"><label for="depart">Yellow</label>
						</fieldset>	
					</div>
					 -->

					<button class="hollow button rounded bordered" type="submit" href="#">Envoyez</button>
				</form>
			</div>
			<!-- Results -->
			<div class="cell medium-4 medium-cell-block-y">
				<table class="hover">
					<?php
						include_once 'connexion.php';
						$collname = 'villes';
						try {
							if (isset($_GET['submit'])) {
								$nomVille = $_GET[ville].value;
								$pipeline = [
									['$match' => ['nom' => $nomVille]],
									['$lookup' => ['from' => 'departements',
												   'localField' => '_id_dept',
												   'foreignField' => '_id',
												   'as' => 'dept']],
									['$unwind' => '$dept'],
									['$project' => ['_id' => 1,
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
								$command = new MongoDB\Drive\Command(['aggregate' => $collname, 'pipeline' => $pipeline]);
								$rows = $Connexion -> executeCommand($dbname, $command) -> toArray();
								echo "<ol>\n";
								foreach($rows as $doc) {
									echo "<li><ul>\n";
									foreach ($doc as $key => $val) {
									printf("<li>%s = <em>%s</em>\n", $key, $val);
									}
									echo "</ul></li>\n";    
								}
								echo "</ol>\n";
							} else {

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