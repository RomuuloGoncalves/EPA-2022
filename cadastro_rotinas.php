<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de rotinas</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/style_cadastros.css">
  <link rel="stylesheet" href="assets/css/style_cadastro_rotinas.css">
</head>

<body>
	<header>
    <a href="index.php" id="container__logo">
      <img id="logo" src="assets/img/Logo DS - EPA.png" alt="Logo" />
      <h1>EPA-2022</h1>
    </a>
	</header>

  <main>
    <div id="titulo__cadastro">
      <h1>Cadastro de rotinas:</h1>
      <nav>
        <a href="index.php">
        <img src="assets/img/seta.png" alt="Voltar">
      </a>
      </nav>
    </div>

    <form action="" method="POST">
      <div class="campos">
        <label for="nome">Nome:*</label>
        <input type="text" id="nome" name="nome">

        <div class="campo__horario">
          <label for="hora_acender">Horário para acender:*</label>
          <input type="time" id="hora_acender" name="hora_acender">

          <label for="hora_apagar">Horário para apagar:*</label>
          <input type="time" id="hora_apagar" name="hora_apagar">
        </div>
      </div>

      <div class="campos">
        <label for="selecao">Selecione as lâmpadas que pertencerão a este grupo*</label>

      </div>

      <div class="botoes">
        <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
        <button type="reset" class="botao" id="btn__reset">Limpar</button>
      </div>
    </form>
  </main>
</body>
<script src="assets/js/script.js"></script>
</html>