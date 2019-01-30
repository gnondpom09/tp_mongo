<?php 
	include 'header.php'; 
?>

	<!--Cover Box-->
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

		<!--Login-->
		<div class="container-fluid">
			<div class="row justify-content-end">
				<div class="col-2">
					<a class="navbar-brand" href="#">CONNEXION</a>
				</div>
			</div>
		</div>

		<!--Center Text-->
		<main role="main" class="inner cover">
			<h1 class="cover-heading">GEO FRANCE</h1>
			<!--<p class="lead">.</p>-->
		</main>

	    <!-- Menu -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">LDNR</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Accueil<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Visualisation</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Maintenance</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>

<?php include 'footer.php'; ?>