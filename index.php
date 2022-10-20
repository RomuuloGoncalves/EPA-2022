<?php
require 'functions/atualizar_db_rotinas.php';
require 'lib/conn.php';

// atualizar_db_rotinas();

$select = 'SELECT * FROM GRUPOS';
$stmt = $conn->query($select);
$grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

$select = 'SELECT * FROM LAMPADAS';
$stmt = $conn->query($select);
$lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);

$select = 'SELECT * FROM ROTINAS';
$stmt = $conn->query($select);
$rotinas = $stmt->fetchAll(PDO::FETCH_OBJ);

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
	<link rel="stylesheet" href="assets/css/style_index.css">
	<link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
	<header>
		<a href="index.php" id="container__logo">
			<img id="logo" src="assets/img/Logo DS - EPA.png" alt="Logo" />
			<h1>EPA-2022</h1>
		</a>

		<input type="checkbox" id="responsive-menu">
		<label for="responsive-menu" class="responsive-menu"><span></span></label>

		<nav class="menu">
			<a href="cadastro_lampadas.php">Lâmpadas
				<img src="assets/img/mais.png" alt="mais">
			</a>
			<a href="cadastro_grupos.php">Grupos
				<img src="assets/img/mais.png" alt="mais">
			</a>
			<a href="cadastro_rotinas.php">Rotina
				<img src="assets/img/mais.png" alt="mais">
			</a>
		</nav>
	</header>

	<main>
		<div class="containers" id="container__lampadas">

			<div class="header__slider">
				<a class="link__listagem" href="listar_lampadas.php">
					<h2>Lâmpadas</h2>
				</a>
				<nav>
					<a href="cadastro_lampadas.php">
						<img src="assets/img/mais.png" alt="mais" />
					</a>
				</nav>
			</div>

			<div class="slide" id="lampadas">
				<?php

				if(count($lampadas) > 0){


				foreach ($lampadas as $lampada) {
				?>
					<div class="card card__lampada">
						<a href="functions/mudar_estado_lampada.php?id=<?= $lampada->ID_LAMPADA ?>&est=<?= $lampada->ESTADO ?>">
							<img src="./assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada <?= $lampada->ESTADO ?>" />
						</a>
						<a href="lampada.php?id=<?= $lampada->ID_LAMPADA ?>">
							<p><?= $lampada->NOME ?></p>
						</a>
					</div>
				<?php
				}
				unset($lampadas);
			}else{
				?>
					<div class="texto__aviso">
							Não há lâmpadas cadastradas, para cadastrar clique <a href="./cadastro_lampadas.php">aqui</a>
					</div>
				<?php
			}
				?>
			</div>

		</div>

		<div class="containers" id="container__grupos">
			<div class="header__slider">
				<a class="link__listagem" href="listar_grupos.php">
					<h2>Grupos</h2>
				</a>
				<nav>
					<a href="cadastro_grupos.php">
						<img src="assets/img/mais.png" alt="mais" />
					</a>
				</nav>
			</div>

			<div class="slide" id="grupos">
				<?php
				if (count($grupos) > 0) {
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
									<img src="./assets/img/info.png" alt="info">
								</a>
							</div>
						</div>
					<?php
					}
					unset($grupos);
					unset($est_grp);
					unset($estado_switch);
				} else {
					?>
					<div class="texto__aviso">
						Não há grupos cadastrados, para cadastrar clique <a href="./cadastro_grupos.php">aqui</a>
					</div>
				<?php
				}
				?>

			</div>
		</div>

		<div class="containers" id="container__rotinas">
			<div class="header__slider">
				<a class="link__listagem" href="listar_rotinas.php">
					<h2>Rotinas</h2>
				</a>
				<nav>
					<a href="cadastro_rotinas.php">
						<img src="assets/img/mais.png" alt="mais" />
					</a>
				</nav>
			</div>

			<div class="slide" id="rotinas">
				<?php
				if (count($rotinas) > 0) {

					foreach ($rotinas as $rotina) {
				?>
						<div class="card card__rotinas">
							<img id="img__relogio" src="assets/img/relogio.png" alt="relogio" />

							<a href="">
								<img id="img__rotina" src="assets/img/rotina_<?= $rotina->ESTADO ?>.png" alt="Estado <?= $rotina->ESTADO ?>" />
							</a>

							<div class="page__titulo">
								<p><?= $rotina->NOME ?></p>
								<a href="rotina.php?id=<?= $rotina->ID_ROTINA ?>">
									<img src="./assets/img/info.png" alt="info">
								</a>
							</div>
						</div>
					<?php
					}
				} else {
					?>
					<div class="texto__aviso">
						Não há rotinas cadastradas, para cadastrar clique <a href="./cadastro_rotinas.php">aqui</a>
					</div>
				<?php
				}

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

		<h3>Ícones por <a href="https://www.flaticon.com/br/" title="Flaticon">www.flaticon.com</a></h3>

		<span>2ºDS - Projeto EPA 2022</span>
	</footer>
</body>

</html>