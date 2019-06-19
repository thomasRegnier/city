<?php


require_once 'tools/tools.php';

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
	header('location:../index.php');
	exit;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administration - Mairie de Saint leu</title>
		<?php require 'partials/head_assets.php'; ?>
	</head>
	<body class="index-body">
		<div class="container-fluid">
			<?php require 'partials/header.php'; ?>
			<div class="row my-3 index-content">
				<?php require 'partials/nav.php'; ?>
				<main class="col-9">

				</main>
			</div>
		</div>
	</body>
</html>

