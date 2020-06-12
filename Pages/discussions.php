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
			<aside class="col-md-2 d-none d-lg-block menu">
				<div class="flex-menu ">
					<span><a href="discussions.php"><i class="icofont-plus rounded rounded-circle"></i></a><br>Nouvelle discussion</span>
					<span><a href="#discusses-table"><i class="icofont-chat rounded rounded-circle"></i></a><br>Discussions</span>
					<span><a href=""><i class="icofont-clip rounded rounded-circle signout"></i></a><br>Contenu</span>
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
							<?php
								$pastous = 'checked disabled';
								$tous = 'checked';
								$s1 = ''; $s2 =''; $l1 = ''; $l2='';

								if(isset($_GET['id']))
								{
									$cible = $manager->getUnique($_GET['id'])->cible();
									
									if($cible != 'tous')
									{
										$tous = '';
										$pastous = '';
										if(strstr($cible, "S1"))
										{
											$s1 = 'checked';
										}
										if(strstr($cible, "S2"))
										{
											$s2 = 'checked';
										}
										if(strstr($cible, "L'"))
										{
											$l1 = 'checked';
										}
										if(strstr($cible, "L2"))
										{
											$l2 = 'checked';
										}
									}
								}
							?>
							<label for="spe">Pour : </label>
							<input type="checkbox" name="tout" class="tous"  <?= $tous ?>> Tous
							<input type="checkbox" name="S1" class="pastous" <?= $pastous, $s1 ?>> S1 
							<input type="checkbox" name="S2" class="pastous" <?= $pastous, $s2?>> S2 
							<input type="checkbox" name="L'" class="pastous" <?= $pastous, $l1?>> L' 
							<input type="checkbox" name="L2" class="pastous" <?= $pastous, $l2?>> L2
							
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
							<th scope="col">cible</th>
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

							if($discuss->iduser() == $user->iduser()) {
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
							<td><?= $discuss->cible(); ?></td>
							<td><?= $discuss->datedajout_discuss()->format('d/m/Y à H\hi'); ?></td>
							<td><?= $discuss->datemodif_discuss()->format('d/m/Y à H\hi'); ?></td>
						</tr>
						<?php
								}
							} 
						?>
					</tbody>
				</table>
				<?php
					if($_SESSION['toshow']=='') $toshow='tous';
					else $toshow = $_SESSION['toshow'];
				?>

				<form id="filter-form" action="../Manager/Action/Filter.php" methode='post' style="padding: 10px; margin-top: 20px; margin-bottom: 0px;">
					<div class="form-group">
							<label for="spe">Filtrer : </label>
							<input type="checkbox" name="tout" class="Tous" <?= ($toshow == 'tous') ? 'checked' : ''?>> Tous
							<input type="checkbox" name="S1" class="Pastous" <?= ($toshow == 'tous') ? 'disabled' : ''?> <?= strstr($toshow, 'S1') ? 'checked' : '' ; ?> <?= ($user->subject() == 'S1') ? 'checked disabled' : ''?>> S1 
							<input type="checkbox" name="S2" class="Pastous"  <?= ($toshow == 'tous') ? 'disabled' : ''?> <?= strstr($toshow, 'S2') ? 'checked' : '' ; ?> <?= ($user->subject() == 'S2') ? 'checked disabled' : ''?>> S2 
							<input type="checkbox" name="L'" class="Pastous"  <?= ($toshow == 'tous') ? 'disabled' : ''?> <?= strstr($toshow, 'L\'') ? 'checked' : '' ; ?> <?= ($user->subject() == 'L\'') ? 'checked disabled' : ''?>> L' 
							<input type="checkbox" name="L2" class="Pastous"  <?= ($toshow == 'tous') ? 'disabled' : ''?> <?= strstr($toshow, 'L2') ? 'checked' : '' ; ?> <?= ($user->subject() == 'L2') ? 'checked disabled' : ''?>> L2
						</div>
				</form>
				
				<table class="table table-hover table-bordered" id="discusses-table">
					<thead style="background-color: #00f;color: #fff">
						<tr>
							<th scope="row">Autres</th>
							<th scope="col">Problème</th>
							<th scope="col">Détails</th>
							<th scope="col">cible</th>
							<th scope="col">date d'ajout</th>
							<th scope="col">Dernière Modification</th>
						</tr>
					</thead>
					<tbody>

						<?php
						foreach ($discusses as $discuss) 
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
						<?php
							$cible = explode(' ', $toshow);
							$element = false;

							if($discuss->iduser() != $user->iduser()) {
								if($toshow != 'tous') {
									foreach ($cible as $cible_toshow) {
										if($cible_toshow=="") continue;
										if(strstr($discuss->cible(), $cible_toshow))
										{
											$element = true;
											break;
										}
									}
									if(!$element) continue;
								}
						?>

							<tr>
							<th scope="row" style="text-align: center; font-size: 25px; color: #00f;">

								<a href="chats.php?id=<?=$discuss->iddiscuss(); ?>" style="text-decoration: none;">
									<i class="icofont-eye" title="voir" style="color:#00f" data-toggle='popover' data-placement = 'top' data-content = 'Voir'></i>
								</a>
							</th>
							<td><?= $discuss->problem() ; ?></td>
							<td><?= $details; ?></td>
							<td><?= $discuss->cible(); ?></td>
							<td><?= $discuss->datedajout_discuss()->format('d/m/Y à H\hi'); ?></td>
							<td><?= $discuss->datemodif_discuss()->format('d/m/Y à H\hi'); ?></td>
						</tr>
						<?php
								}
							} 
						?>
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