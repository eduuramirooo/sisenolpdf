<?php
require_once 'conectar.php';
$db = new Conectar("localhost", "root", "", "docssisenol");

if (isset($_GET['id'])) {
  $db->hacer_consulta("DELETE FROM parque WHERE id = ?", "i", [$_GET['id']]);
}

header("Location: dashboard.php");
exit;
