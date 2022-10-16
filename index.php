<?php
require 'lib/conn.php';
require 'functions/atualizar_json.php';

atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', 'json/lampadas.json');
$select = 'SELECT * FROM GRUPOS';
$stmt = $conn->query($select);
$grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

$select = 'SELECT * FROM LAMPADAS';
$stmt = $conn->query($select);
$lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);

unset($select);
unset($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dashboard</title>
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/style.css" />
	<link rel="stylesheet" href="assets/css/style_index.css">
</head>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

<body>
	<header>
		<a href="index.php" id="container__logo">
			<img id="logo" src="assets/img/Logo DS - EPA.png" alt="Logo" />
		</a>
		<h1>EPA-2022</h1>
	</header>

	<main>
		<div class="containers" id="container__lampadas">

			<div class="header__slider">
				<h2>Lâmpadas</h2>
				<nav>
					<a href="cadastro_lampadas.php">
						<img src="assets/img/mais.png" alt="mais" />
					</a>
				</nav>
			</div>

			<div class="slide" id="lampadas">
				<?php
				foreach ($lampadas as $lampada) {
				?>
					<div class="card card__lampada">
						<a href="functions/mudar_estado_lampada.php?id=<?= $lampada->ID_LAMPADA ?>&est=<?= $lampada->ESTADO ?>">
							<img src="assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada <?= $lampada->ESTADO ?>" />
						</a>
						<a href="lampada.php?id=<?= $lampada->ID_LAMPADA ?>">
							<p><?= $lampada->NOME ?></p>
						</a>
					</div>
				<?php
				}
				unset($lampadas);
				?>
			</div>

		</div>

		<div class="containers" id="container__grupos">
			<div class="header__slider">
				<h2>Grupos</h2>
				<nav>
					<a href="cadastro_grupos.php">
						<img src="assets/img/mais.png" alt="mais" />
					</a>
				</nav>
			</div>

			<div class="slide" id="grupos">
				<?php
				foreach ($grupos as $grupo) {
					$select = 'SELECT * FROM LAMPADAS_GRUPO INNER JOIN LAMPADAS ON LAMPADAS.ID_LAMPADA = LAMPADAS_GRUPO.ID_LAMPADA WHERE LAMPADAS.ESTADO = 1 AND LAMPADAS_GRUPO.ID_GRUPO = :id_grupo';
					$stmt = $conn->prepare($select);
					$stmt->bindValue(':id_grupo', $grupo->ID_GRUPO);
					$stmt->execute();
					$qtdd_acessas = $stmt->rowCount();

					$select = 'SELECT * FROM LAMPADAS_GRUPO WHERE LAMPADAS_GRUPO.ID_GRUPO = :id_grupo';
					$stmt = $conn->prepare($select);
					$stmt->bindValue(':id_grupo', $grupo->ID_GRUPO);
					$stmt->execute();
					$qtdd_lampadas = $stmt->rowCount();

					unset($select);
					unset($stmt);

					if ($qtdd_lampadas ===  $qtdd_acessas) {
						$est_grp = 1;
						$estado_switch = 'checked';
					} else {
						$est_grp = 0;
						$estado_switch = '';
					}

					unset($qtdd_lampadas);
					unset($qtdd_acessas);
				?>
					<div class="card card__grupo">
						<img src="assets/img/lampada_<?= $est_grp ?>.png" alt="Lampada <?= $est_grp ?>" />

						<label for="checkbox-<?= $grupo->ID_GRUPO ?>" class="switch">
							<a href="functions/mudar_estado_grp.php?id=<?= $grupo->ID_GRUPO ?>&est=<?= ($est_grp === 1) ? 0 : 1 ?>">
								<input type="checkbox" name="checkbox" id="checkbox-<?= $grupo->ID_GRUPO ?>" <?= $estado_switch ?> />
								<span class="slider"></span>
							</a>
						</label>

						<div class="page__titulo">
							<p><?= $grupo->NOME ?></p>
							<a href="grupo.php?id=<?= $grupo->ID_GRUPO ?>">
								<ion-icon name="information-circle-outline"></ion-icon>
							</a>
						</div>
					</div>
				<?php
				}
				unset($grupos);
				unset($est_grp);
				unset($estado_switch);
				?>
			</div>
		</div>
	</main>

	<footer>
		<div class="text__footer">
			<h3>Desenvolvido por:</h3>

			<p>Beatriz Meyagusko</p>
			<p>Pedro de Sousa Vicente</p>
			<p>Rômulo da Silva Gonçalves</p>

		</div>
		<a href="https://www.flaticon.com/br/icones-gratis/lampada" title="lâmpada ícones">Ícones lâmpadas por: Freepik
			- Flaticon</a>

		<span>2ºDS - Projeto EPA 2022</span>
	</footer>
</body>

</html>