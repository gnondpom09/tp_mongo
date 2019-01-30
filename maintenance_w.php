<?php 
	include 'header.php'; 
?>

		<!-- Center Text -->
		<div class="grid-x"> <!-- need to add justify-center: center in css -->
			<div class="cell small-4">GEO FRANCE</div>
		</div>

	    <!-- Menu -->
		<div class="title-bar" data-responsive-toggle="example-animated-menu" data-hide-for="medium">
  			<button class="menu-icon" type="button" data-toggle></button>
 			 <div class="title-bar-title">Visualisation d'une ville</div>
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

 <div id="main">
            <div id="intro">
                <p>Veuillez saisir la collection à modifier :</p>
            </div>

            <div id="buttons_type">
                <button id="ville" type="button" onclick="">ville</button>
                <button id="dept" type="button" onclick="">dept</button>
                <button id="region" type="button" onclick="">region</button>
            </div>

            div class="modal-register">
            <img src="ressources/ldnr_logo.png" alt="logo">
            <div class="modal__inner">
                <form action="" method="post" id="register-user">
                    <p class="login-email">
                        <label for="email-user">Email</label>
                        <input type="email" name="email" id="email-user" placeholder="Email" >
                    </p>
                    <p class="login-password">
                        <label for="pass-user">Mot de passe</label>
                        <input type="password" name="password" id="pass-user" placeholder="Mot de passe" >
                    </p>
                    <p class="login-password">
                        <label for="repeat-password">Mot de passe</label>
                        <input type="password" name="repeat" id="repeat-password" placeholder="Répéter le mot de passe" >
                    </p>
                    <input type="submit" value="Créer mon compte">
                </form>
            </div>
        </div>
        </div>
        

<?php

// // Sélection de la collection villes
// $c_villes = new MongoCollection($db, "villes");



//  // sélectionner ville si département et region rempli :
//  $get_villes = $c_villes->find({nom: "nom_ville", _id_dept: "c_dept", _id_region:"c_region"});


?>


<?php 
	include 'footer.php'; 
?>