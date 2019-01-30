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

<       <div id="main">
            <div id="intro">
                <p>Veuillez saisir la collection à modifier :</p>
            </div>

            <div id="buttons_type">
                <button id="ville" type="button" onclick="">ville</button>
                <button id="dept" type="button" onclick="">dept</button>
                <button id="region" type="button" onclick="">region</button>
            </div>

            <form id="form">

                <div id="infos_area">
                    
                    <div id="input_area">
                        <div>
                            <input type="data" id="input_data" name="input_data" placeholder="">
                        </div>
                        
                    </div>
                    
                </div>
                <div id="update_ville" type="text">
                    
                </div>

               
            </form>
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