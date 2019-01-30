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
      						<input type="text" id="middle-label" placeholder="">
   						</div>
					</div>
					<div class="grid-x grid-padding-x align-spaced">
						<div class="medium-1 cell">
      						<label for="middle-label" class="text-right middle">Département</label>
    					</div>
    					<div class="medium-2 cell">
      						<input type="text" id="middle-label" placeholder="">
   						</div>
					</div>
					<div class="grid-x grid-padding-x align-spaced">
						<div class="medium-1 cell">
      						<label for="middle-label" class="text-right middle">Région</label>
    					</div>
    					<div class="medium-2 cell">
      						<input type="text" id="middle-label" placeholder="">
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
					?>
				</table>
			</div>
		</div>

<?php 
	include 'footer.php'; 
?>