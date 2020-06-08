<?php
session_start();

require '../Manager/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new DiscussManager_PDO($db);

if(!isset($_SESSION['user']))
{
	header('Location: ../index.php');
}
else
{
	$user = unserialize($_SESSION['user']);
}


$discusses = $manager->getList();

if(isset($_GET['id']))
{
	if($manager->getUnique($_GET['id']) == null)
		header('Location: ../error.php');
}
if(isset($_GET['del']))
{
	$manager->delete($_GET['del']);
	header('Location: discussions.php#discusses-table');
}

?>
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
					<span><a href="discussions.php"><i class="icofont-plus rounded rounded-circle"></i></a><br>Nouvelle discussion</span>
					<span><a href="#discusses-table"><i class="icofont-chat rounded rounded-circle"></i></a><br>Discussions</span>
					<span><a href=""><i class="icofont-share rounded rounded-circle "></i></a><br>Partager</span>
					<span><a href="../index.php"><i class="icofont-home rounded rounded-circle"></i></a><br>Accueil</span>
				</div>
			</aside>

			<article id="chatbox" class="col-md-10">
				<!--=== Ajout de nouvelles discussions ===-->
				<div id="newDiscuss">
					<form id="discuss-form" action="../Manager/Action/Discuss-form-submit.php">
						<input type="hidden" name="update" value="<?= (isset($_GET['id'])) ? $_GET['id'] : false ; ?>">

						<input type="hidden" name="delete" value="<?= (isset($_GET['del'])) ? $_GET['del'] : false ; ?>">

						<div class="form-group">
							<label for="pro">Problème</label>

							<input type="text" name="problem" class="form-control" id="pro" value="<?= (isset($_GET['id'])) ? $manager->getUnique($_GET['id'])->problem() : "" ;?>">
						</div>

						<div class="form-group">
							<label for="detaille">Détails</label>

							<textarea name="detail" placeholder="expliciter le problème" class="form-control" id="detaille"><?= (isset($_GET['id'])) ? $manager->getUnique($_GET['id'])->details()  : "" ;?></textarea>
						</div>

						<button class="btn btn-primary"><?= (isset($_GET['id'])) ? "Appliquer" : "Ajouter" ;?></button> 
					</form>
				</div>

				<table class="table table-hover table-bordered" id="discusses-table">
					<thead style="background-color: #f00;color: #fff">
						<tr>
							<th scope="row">Mes discussions</th>
							<th scope="col">Problème</th>
							<th scope="col">Détails</th>
							<th scope="col">date d'ajout</th>
							<th scope="col">Dernière Modification</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($discusses as $discuss) 
						{
							if(strlen($discuss->details()) < 100)
							{
								$details = $discuss->details();
							}
							else
							{
								$debut = substr($discuss->details(), 0, 100);
								$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
								$details = $debut;
							}
						?>
							<tr style="background-color: <?= ($discuss->iduser()==$user->iduser()) ? "#FFE6DE" : '' ?>";>
							<th scope="row" style="text-align: center; font-size: 25px; color: #00f;">

								<a href="chats.php?id=<?=$discuss->iddiscuss(); ?>" style="text-decoration: none;">
									<i class="icofont-eye" title="voir" style="color:#00f"></i>
								</a>

								<?php if($discuss->iduser()==$user->iduser()) {?>
								<a href="discussions.php?id=<?=$discuss->iddiscuss(); ?>" style="text-decoration: none;">
									<i class="icofont-pencil" title="modifier" style="color:#0f0"></i>
								</a>

								<a href="discussions.php?del=<?=$discuss->iddiscuss(); ?>" style="text-decoration: none;">
									<i class="icofont-bin" title="Supprimer" style="color:#f00"></i>
								</a>
								<?php }?>
							</th>
							<td><?= $discuss->problem(); ?></td>
							<td><?= $details; ?></td>
							<td><?= $discuss->datedajout_discuss()->format('d/m/Y à H\hi'); ?></td>
							<td><?= $discuss->datemodif_discuss()->format('d/m/Y à H\hi'); ?></td>
						</tr>
						<?php
							} 
						?>
					</tbody>
				</table>

				<table class="table table-hover table-bordered" id="discusses-table">
					<thead style="background-color: #00f;color: #fff">
						<tr>
							<th scope="row">Autres</th>
							<th scope="col">Problème</th>
							<th scope="col">Détails</th>
							<th scope="col">date d'ajout</th>
							<th scope="col">Dernière Modification</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($discusses as $discuss) 
						{
							if(strlen($discuss->details()) < 100)
							{
								$details = $discuss->details();
							}
							else
							{
								$debut = substr($discuss->details(), 0, 100);
								$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
								$details = $debut;
							}

							if($discuss->iduser() != $user->iduser()) {
						?>
							<tr>
							<th scope="row" style="text-align: center; font-size: 25px; color: #00f;">

								<a href="chats.php?id=<?=$discuss->iddiscuss(); ?>" style="text-decoration: none;">
									<i class="icofont-eye" title="voir" style="color:#00f"></i>
								</a>
							</th>
							<td><?= $discuss->problem(); ?></td>
							<td><?= $details; ?></td>
							<td><?= $discuss->datedajout_discuss()->format('d/m/Y à H\hi'); ?></td>
							<td><?= $discuss->datemodif_discuss()->format('d/m/Y à H\hi'); ?></td>
						</tr>
						<?php
								}
							} 
						?>

						<?php for($i=0; $i<5; $i++) {?>
						<tr>
							<th scope="row" style="text-align: center; font-size: 25px; color: #00f;">

								<a href="chats.php" style="text-decoration: none;">
									<i class="icofont-eye" title="voir" style="color:#00f"></i>
								</a>
								
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


	<!--=== JS Vendor ===-->
	<script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/jquery.color/jquery.color.js"></script>
	<script type="text/javascript" src="../assets/vendor/venobox/venobox.js"></script>
	<script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.js"></script>

	<!--=== My JS files ===-->
	<script type="text/javascript" src="../assets/js/index.js"></script>
	<script type="text/javascript" src="../assets/js/validate-forms.js"></script>
</body>
</html>