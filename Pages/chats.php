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
			<aside class="col-md-2 d-none d-lg-block">
				<div class="flex-menu">
					<span><a href="discussions.php"><i class="icofont-plus rounded rounded-circle"></i></a><br>Nouvelle discussion</span>
					<span><a href="discussions.php#discusses-table"><i class="icofont-chat rounded rounded-circle "></i></a><br>Discussions</span>
					<span><a href=""><i class="icofont-share rounded rounded-circle "></i></a><br>Partager</span>
					<span><a href="../index.php"><i class="icofont-home rounded rounded-circle"></i></a><br>Accueil</span>
				</div>
			</aside>

			<article id="chatbox" class="col-md-6 col-sm-12">
				<div id="chats">
					<!--In phones -->
					<div class="d-lg-none">
							<h2><i class="icofont-question-circle"></i> Problèmatique</h2>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					</div>

					<div id="answer" class="d-lg-none">
						<textarea placeholder="répondre au problème ici"></textarea>
						<button class="btn rounded rounded-circle"><i class="icofont-paper-plane"></i></button>
					</div>

					<?php for($i = 0; $i<10; $i++) {?>
						<h3><i class="icofont-unique-idea"></i> Author  - <small><em>17/05/2020 à 17h 20mn</em></small></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						<aside id="small-flex-menu">
							
						</aside>
					<?php }?>

				</div>
			</article>
			
			<aside class="col-md-4 d-none d-lg-block" id="board">
				<div style="position: fixed;background-color: #fff;">
					<div id="problem">
						<h2><i class="icofont-question-circle"></i> Problèmatique</h2>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					</div>
					<div id="mydiscuss">
						<h2><i class="icofont-stack-overflow"></i> Mes discussions</h2>
						<ul class="list-unstyled">
							<li><button class="btn">quis nostrud exercitation ullamco laboris nisi ...</button></li>
							<li><button class="btn">quis nostrud exercitation ullamco laboris nisi ...</button></li>
							<li><button class="btn">quis nostrud exercitation </button></li>
						</ul>
					</div>

					<div id="answer">
						<textarea placeholder="répondre au problème ici"></textarea>
						<button class="btn rounded rounded-circle"><i class="icofont-paper-plane"></i></button>
					</div>
				</div>
			</aside>
		</div>
	</main>

	<!--=== footer ===-->
	<?php include_once("footer.php"); ?>
</body>
</html>