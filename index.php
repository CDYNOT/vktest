<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('classes/main.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
		<title>Задача с лабиринтом - Новиков Антон Олегович @CDYNOT</title>
		
		<link rel="stylesheet" href="css/styles.css">	
	</head>
	<body>
		<div class="wrap">
			<div class="cont">
				<div class="labyrinth">
					<form method="post" id="labyrinth">
						<input type="hidden" id="begin" name="begin" value="<?= $coordinates['begin'] ?>">
						<input type="hidden" id="end" name="end" value="<?= $coordinates['end'] ?>">
					
						<div class="block_title">Задача поиска кратчайшего пути в лабиринте</div>
						
						<div class="box flex">
							<? require_once('view/data.php') ?>
							<? require_once('view/matrix.php') ?>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<script src="js/scripts.js"></script>
	</body>
</html>
