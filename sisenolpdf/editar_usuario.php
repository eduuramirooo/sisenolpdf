<?php
require_once 'conectar.php';
$db = new Conectar("localhost", "root", "", "docssisenol");

if (isset($_POST['id'])) {
  $db->hacer_consulta(
    "UPDATE usuario SET nombre = ?, apellido = ?, apellido2 = ?, NIF = ?, municipio = ?, direccion = ? WHERE id = ?",
    "ssssssi",
    [
      $_POST['nombre'],
      $_POST['apellido'],
      $_POST['apellido2'],
      $_POST['NIF'],
      $_POST['municipio'],
      $_POST['direccion'],
      $_POST['id']
    ]
  );
}

header("Location: dashboard.php");
exit;
