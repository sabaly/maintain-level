<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Maintain-level</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!--=== favicon ===-->
	<!--link href="assets/img/favicon-kolo.png" rel="icon"-->

	<!--=== css du vendor ===-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/vendor/icofont/icofont.min.css">
	
	<!--=== mon fichier css ===--->
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	

  	<!--=== Google Fonts ===-->
  	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
	<!--=== header ===-->
	<?php include_once("header.php"); ?>

	<main id="main">
		<div class="container chatBody">
			<aside class="col-md-2 d-none d-lg-block">
				<div class="flex-menu ">
					<span><a href=""><i class="icofont-plus rounded rounded-circle"></i></a><br>Nouvelle discussion</span>
					<span><a href="#discusses-table"><i class="icofont-chat rounded rounded-circle"></i></a><br>Discussions</span>
					<span><a href=""><i class="icofont-share rounded rounded-circle "></i></a><br>Partager</span>
					<span><a href="../index.php"><i class="icofont-home rounded rounded-circle"></i></a><br>Accueil</span>
				</div>
			</aside>

			<article id="chatbox" class="col-md-10">
				<!--=== Ajout de nouvelles discussions ===-->
				<div id="newDiscuss">
					<form>
							<div class="form-group">
								<label for="pro">Problème</label>
								<input type="text" name="problem" class="form-control" id="pro">
							</div>

							<div class="form-group">
								<label for="detaille">Détails</label>
								<textarea name="detail" placeholder="expliciter le problème" class="form-control" id="detaille"></textarea>
							</div>

							<button class="btn btn-primary">Ajouter</button>
					</form>
				</div>

				<table class="table table-hover table-bordered" id="discusses-table">
					<thead style="background-color: #00f;color: #fff">
						<tr>
							<th scope="col">Suivre</th>
							<th scope="col">Problème</th>
							<th scope="col">date d'ajout</th>
							<th scope="col">Dernière Modification</th>
							<th scope="col">Détails</th>
						</tr>
					</thead>
					<tbody>
						<?php for($i=0; $i<5; $i++) {?>
						<tr>
							<th scope="row" style="text-align: center; font-size: 25px; color: #00f;">
								<a href="chats.php" style="text-decoration: none;"><i class="icofont-eye" title="voir" style="color:#00f"></i></a>
								<a href="" style="text-decoration: none;"><i class="icofont-pencil" title="modifier" style="color:#0f0"></i></a>
								<a href="" style="text-decoration: none;"><i class="icofont-bin" title="Supprimer" style="color:#f00"></i></a>
							</th>
							<td>cell</td>
							<td>cell</td>
							<td>cell</td>
							<td>cell</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>

			</article>

		</div>
	</main>

	<!--=== footer ===-->
	<?php include_once("footer.php"); ?>
</body>
</html>