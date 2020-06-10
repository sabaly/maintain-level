<?php
session_start();

require '../Manager/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new ChatManager_PDO($db);
$manager_discuss = new DiscussManager_PDO($db);

$mydiscusses = $manager_discuss->getList();

if(!isset($_SESSION['user']))
{
	header('Location: ../index.php');
}
else
{
	$user = unserialize($_SESSION['user']);
}


if(isset($_GET['id']))
{
	$discuss = $manager_discuss->getUnique($_GET['id']);
	if($discuss == null)
		header('Location: ../error.php');

	$chats = $manager->chatFromDiscuss($_GET['id']);
}
if(isset($_GET['upd']))
{
	if($manager->getUnique($_GET['upd']) == null){
		header('Location: ../error.php');
	}
}

if(isset($_GET['del']))
{
	$manager->delete($_GET['del']);
	header('Location: chats.php?id='.$_GET['id']);
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
		<div class="container-fluid chatBody">
			<aside class="col-md-2 d-none d-lg-block menu">
				<div class="flex-menu">
					<span><a href="discussions.php"><i class="icofont-plus rounded rounded-circle"></i></a><br>Nouvelle discussion</span>
					<span><a href="discussions.php#discusses-table"><i class="icofont-chat rounded rounded-circle "></i></a><br>Discussions</span>
					<span><a href=""><i class="icofont-clip signout rounded rounded-circle "></i></a><br>Contenu</span>
					<span><a href="../index.php"><i class="icofont-home rounded rounded-circle"></i></a><br>Accueil</span>
				</div>
			</aside>

			<article id="chatbox" class="col-md-6 col-sm-12">
				<div id="chats">
					<!--In phones -->
					<!--==== button to check the problem ===-->
					<button class="btn d-lg-none mobile-problem mobile-pro-toggle"><i class="icofont-question rounded rounded-circle"></i></button>

					<button class="btn d-lg-none mobile-answer mobile-ans-toggle"><i class="icofont-paper-plane rounded rounded-circle"></i></button>
					
					<div class="d-none problem-in-mobile">
							<h2><i class="icofont-question-circle"></i> Problèmatique</h2>
							<h6><?= $discuss->problem() ; ?></h6>
							<p>
								<?= $discuss->details() ; ?>
							</p>
					</div>

					<div class="d-none answer-in-mobile">
						<form id="mobile-chat-form" action="../Manager/Action/Chat-form-submit.php">
							<div class="form-group">
								<input type="hidden" name="update" value="<?= (isset($_GET['upd'])) ? $_GET['upd'] : false ; ?>">

								<input type="hidden" name="iddiscuss" value="<?= $discuss->iddiscuss() ; ?>">

								<textarea placeholder="répondre au problème ici" class="form-control" id="msg-mobile" name="message"><?= (isset($_GET['upd'])) ? $manager->getUnique($_GET['upd'])->message()  : "" ; ?></textarea>

								<button class="btn rounded rounded-circle"><i class="icofont-paper-plane" id="mobile-submit-btn"></i></button>
							</div>
						</form>
					</div>

					<?php foreach ($chats as $chat) {
						$userManager = new UserManager_PDO($db);
						$author = $userManager->getUnique($chat->iduser());
						if($discuss->iduser() != $chat->iduser())
						{
							$class = 'mychat';
							$icon = 'icofont-unique-idea';
						}
						else
						{
							$class = '';
							$icon = 'icofont-waiter';
						}
					?>
						<h3 class="<?= $class ?>"><i class="<?= $icon ; ?>"></i> <?= ($chat->iduser() != $user->iduser()) ? $author->pseudo() : 'Vous' ; ?>

						<?php if($chat->iduser() == $user->iduser()) {?>
							<span id="small-flex-menu" style="font-size: 20px; float: right;">
								<a href="chats.php?upd=<?=$chat->idchat(); ?>&id=<?= $_GET['id']?>" style="text-decoration: none;">
									<i class="icofont-pencil" title="modifier" style="color:#0f0"></i>
								</a>
								<a href="chats.php?del=<?=$chat->idchat(); ?>&id=<?= $_GET['id']?>" style="text-decoration: none;">
									<i class="icofont-bin" title="supprimer" style="color:#f00"></i>
								</a>
							</span>
							<?php }?>

						<br/>
						<small>ajoute le <em><?= $chat->datedajout_chat()->format('d/m/Y') ; ?>; dernière modification le <?= $chat->datemodif_chat()->format('d/m/Y à H\h i\m\n') ; ?> </em></small></h3>
						<p>
							<?=$chat->message() ; ?>
							
						</p>

					<?php } 
					 if($chats==null)
					 {
					 	echo "<p class='no_answer'>Aucune réponse pour l'instant</p>";
					 }

					 ?>

				</div>
			</article>
			
			<aside class="col-md-4 d-none d-lg-block" id="board">
				<div style="position: fixed;background-color: #fff;">
					<div id="problem">
						<h2><i class="icofont-question-circle"></i> Problèmatique</h2>
						<h6><?= $discuss->problem() ; ?></h6>
						<p>
							<?= $discuss->details() ; ?>
						</p>
					</div>
					<div id="mydiscuss">
						<h2><i class="icofont-stack-overflow"></i> Mes discussions</h2>
						<?php
							$mines = false;
							foreach ($mydiscusses as $mydiscuss) {
								if($mydiscuss->iduser() == $user->iduser())
								{
									$mines = true;

							
						?>
						<ul class="list-unstyled">
							<li>
								<button class="btn">
									<?= $mydiscuss->problem() ; ?>
								</button>
							</li>
						</ul>

						<?php 
								}
								
							}

							if(!$mines)
							{
								echo '<p>Vous n\'avez pas encore créer de discussion';
							}
						?>
					</div>

					<div id="answer">
						<form id="chat-form" action="../Manager/Action/Chat-form-submit.php">
							<div class="form-group">
								<input type="hidden" name="update" value="<?= (isset($_GET['upd'])) ? $_GET['upd'] : false ; ?>">

								<input type="hidden" name="iddiscuss" value="<?= $discuss->iddiscuss() ;  ?>">

								<textarea placeholder="répondre au problème ici" name="message" id="msg"><?= (isset($_GET['upd'])) ? $manager->getUnique($_GET['upd'])->message()  : "" ; ?></textarea>
								<button class="btn rounded rounded-circle"><i class="icofont-paper-plane"></i></button>
							</div>
						</form>
					</div>
				</div>
			</aside>
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