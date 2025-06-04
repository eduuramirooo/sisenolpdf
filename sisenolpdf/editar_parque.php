<?php
require_once 'conectar.php';
$db = new Conectar("localhost", "root", "", "docssisenol");

if (isset($_POST['id'])) {
  $db->hacer_consulta(
    "UPDATE parque SET nombre = ?, identificador = ?, ubicacion = ?, potencia_instalada = ?, precio = ? WHERE id = ?",
    "sssddi",
    [
      $_POST['nombre_parque'],
      $_POST['identificador'],
      $_POST['ubicacion'],
      $_POST['potencia_instalada'],
      $_POST['precio'],
      $_POST['id']
    ]
  );
}

header("Location: dashboard.php");
exit;
