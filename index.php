<?php
	session_start();

	if(isset($_GET['end']))
	{
		session_destroy();
	}
/*
	require 'Manager/autoload.php';

	$db = DBFactory::getMysqlConnexionWithPDO();
	$manager = new UserManager_PDO($db);
*/


	if(isset($_SESSION['user'])) {
		$signout = '';
		$signin = 'Connecté';
		$signin_icon = 'icofont-check-circled';
	}
	else 
	{
		$signout = 'signout';
		$signin='Déconnecté';
		$signin_icon = 'icofont-close-circled';
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Maintain-level</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!--=== favicon ===-->
	<!--link href="assets/img/favicon-kolo.png" rel="icon"-->

	<!--=== css du vendor ===-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/icofont/icofont.min.css">
	
	<!--=== mon fichier css ===--->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	

  	<!--=== Google Fonts ===-->
  	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

</head>
<body>
	<!--=== header ===-->
	<header class="container-fluid fixed-top" id="header">
		<div class="container header-content">
			<div style="text-align: center">
				<img src="assets/img/logo.jpg" alt="logo de Maintain-level"/>
				<p class="d-none d-lg-block">Ensemble pour le maintien du niveau des élèves</p>
				<p class="d-lg-none">Maintain-Level</p>
			</div>
			

			<div class="social-networks d-none d-lg-block">
				<a href="#" class="facebook"><i class="icofont-facebook"></i></a>
				<a href="#" class="linkedin"><i class="icofont-linkedin"></i></a>
				<a href="#" class="whatsapp"><i class="icofont-whatsapp"></i></a>
				<a href="#" class="email"><i class="icofont-envelope"></i></a>
				<!--span><i class="icofont-warning status"></i></span-->
			</div>
		</div>
	</header>

	<!--=== Corps ===-->
	<main id="main">
		<article class="container" id="apropos">
			<h2 class="titles"><i class="icofont-info-circle"></i> A propos</h2>
			<p>
				Voici une plateforme d'aide en ligne sous la disposition des élèves candidats. Dans cette plateforme, un candidat peut créer des discussions. Une discussion est un problème posé auquel les autres intervenants (étudiants, enseignants ou d'autres élèves) peuvent apporter des éclaircissements. Il peut aussi suivre les discussions des autres utilisateurs.<br/><br/>
				Quant aux enseignants et étudiants, ils peuvent eux aussi créer des discussions. Ces discussions sont plus souvent pour enseigner des notions particulières.<br/><br/>
				Elève, enseignant et étudiant peuvent partager du contenu : images, documents, lien etc...
			</p>
			<div class="flex-menu">
				<span><a href="<?= ($signout == '') ? 'Pages/discussions.php' : '';?>"><i class="icofont-plus rounded rounded-circle <?= $signout ?>"></i></a><br>Nouvelle discussion</span>
				<span><a href="<?= ($signout == '') ? 'Pages/discussions.php#discusses-table' : '';?>"><i class="icofont-chat rounded rounded-circle <?= $signout ?>"></i></a><br>Discussions</span>
				<span><a href="<?= ($signout == '') ? '#' : '';?>"><i class="icofont-share rounded rounded-circle <?= $signout ?>"></i></a><br>Partager</span>

				<span><a href="<?= ($signin == '') ? '' : '';?>"><i class="<?= $signin_icon?> rounded rounded-circle <?= $signout ?>"></i></a><br><?= $signin ?></span>
			</div>

			<div class="login-form" id="seConnecter">
				<h2 class="titles"><i class="icofont-login"></i> Connexion</h2>
				<form class="form-row" id="login-form" action=" <?= ($signin == 'Connecté') ? '' : 'Manager/Action/Connexion-form-submit.php'?> ">
					<div class="form-group col-md-6">
						<label for="Identifiant">Identifiant</label>
						<input type="text" name="pseudo" class="form-control" id="Identifiant" placeholder="pseudo" <?= ($signin == 'Connecté') ? 'disabled' : ''?>>
					</div>

					<div class="form-group">
						<label for="motDepasse">Mot de passe</label>
						<input type="password" name="psswd" class="form-control" id="motDePasse" placeholder="mot de passe" <?= ($signin == 'Connecté') ? 'disabled' : ''?>>
					</div>

					<div class="form-group btn-submit">
						<button class="btn btn-success" <?= ($signin == 'Connecté') ? 'disabled' : ''?>>Connexion</button>
					</div>
				</form>
				<button class="btn btn-danger" id='disconnect-btn' <?= ($signin == 'Connecté') ? '' : 'hidden'?>>déconnexion</button>	
				<div id="login-alert" class="alert d-none"></div>
			</div>

			<div class="signin-form">
				<h2 class="titles"><i class="icofont-sign-in"></i> Création de compte</h2>
				<form id="signin-form" action="Manager/Action/Inscription-form-submit.php">
					<div class="form-group">
						<label for="iden">Identifiant</label>
						<input type="text" name="pseudo" class="form-control" id="iden" placeholder="pseudo">
						<div id="iden-alert" class="alert d-none"></div>
					</div>

					<div class="form-group">
						<label for="password">Mot de passe</label>
						<input type="password" name="psswd" class="form-control" id="password" placeholder="mot de passe">
						<div id="psswd-alert" class="alert d-none"></div>
					</div>

					<div class="form-group">
						<label for="psswd-conf">Confirmer le mot de passe</label>
						<input type="password" name="psswdConf" class="form-control" id="psswd-conf" placeholder="répéter le mot de passe">
						<div id="rpsswd-alert" class="alert d-none"></div>
					</div>

					<div class="form-group">
						<label for="state">Statut</label>
						<select class="form-control" id="state" name="statut">
							<option>Candidat (e) </option>
							<option>Autres</option>
						</select>
						<div id="status-alert" class="alert d-none"></div>
					</div>

					<div class="form-group">
						<label for="subject">Série ou spécialité</label>
						<select class="form-control" id="subject" name="serie">
							<option>L'</option>
							<option>L2</option>
							<option>S1</option>
							<option>S2</option>
						</select>
						<div id="subject-alert" class="alert d-none"></div>
					</div>
					<button type='submit' class="btn btn-success">Connexion</button>
				</form>
			</div>
		</article>
	</main>

	<!--=== footer ===-->
	<footer class="container-fluid">
		<div class="social-networks d-lg-none">
			<a href="#" class="facebook"><i class="icofont-facebook"></i></a>
			<a href="#" class="linkedin"><i class="icofont-linkedin"></i></a>
			<a href="#" class="whatsapp"><i class="icofont-whatsapp"></i></a>
			<a href="#" class="email"><i class="icofont-envelope"></i></a>
			<!--span><i class="icofont-warning status"></i></span-->
		</div>

		<div class="copyright">
			&copy; Copyright <strong><span>S@dmin</span></strong>-2020, tmssam47@gmail.com
		</div>
	</footer>


	<!--=== JS Vendor ===-->
	<script type="text/javascript" src="assets/vendor/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/vendor/jquery.color/jquery.color.js"></script>
	<script type="text/javascript" src="assets/vendor/venobox/venobox.js"></script>
	<script type="text/javascript" src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<script type="text/javascript" src="assets/vendor/bootstrap/js/bootstrap.js"></script>

	<!--=== My JS files ===-->
	<script type="text/javascript" src="assets/js/index.js"></script>
	<script type="text/javascript" src="assets/js/validate-forms.js"></script>
</body>
</html>