<?php
// admin/dashboard.php
require_once 'conectar.php';
$db = new Conectar("localhost", "root", "", "docssisenol");

// Procesar creación de nuevo usuario
if (isset($_POST['crear_usuario'])) {
  $db->hacer_consulta(
    "INSERT INTO usuario (nombre, apellido, apellido2, NIF, municipio, direccion) VALUES (?, ?, ?, ?, ?, ?)",
    "ssssss",
    [
      $_POST['nombre'], $_POST['apellido'], $_POST['apellido2'],
      $_POST['NIF'], $_POST['municipio'], $_POST['direccion']
    ]
  );
  header("Location: dashboard.php");
  exit;
}

// Procesar creación de nuevo parque
if (isset($_POST['crear_parque'])) {
  $db->hacer_consulta(
    "INSERT INTO parque (nombre, identificador, ubicacion, potencia_instalada, precio) VALUES (?, ?, ?, ?, ?)",
    "sssdd",
    [
      $_POST['nombre_parque'], $_POST['identificador'], $_POST['ubicacion'],
      $_POST['potencia_instalada'], $_POST['precio']
    ]
  );
  header("Location: dashboard.php");
  exit;
}

$usuarios = $db->recibir_datos("SELECT * FROM usuario");
$parques = $db->recibir_datos("SELECT * FROM parque");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleForm(id) {
      const el = document.getElementById(id);
      el.classList.toggle("hidden");
      el.classList.toggle("animate-fade-in");
    }

    function openModal(tipo, id) {
      const modal = document.getElementById(`${tipo}-modal-${id}`);
      modal.classList.remove("hidden");
    }

    function closeModal(id) {
      document.getElementById(id).classList.add("hidden");
    }
  </script>
  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
      animation: fade-in 0.3s ease-out;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen text-sm">
  <header class="bg-white shadow px-6 py-4 flex justify-between items-center sticky top-0 z-50">
    <h1 class="text-xl font-semibold text-gray-800">Panel de Administración</h1>
    <a href="/" class="text-sm text-[#216869] hover:underline">Volver al inicio</a>
  </header>

  <main class="max-w-7xl mx-auto px-6 py-8">
    <!-- USUARIOS -->
    <section class="mb-16">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-[#292727]">Usuarios</h2>
        <button onclick="toggleForm('formUsuario')" class="bg-[#216869] text-white px-4 py-1 rounded hover:bg-[#49A078] transition">+ Nuevo</button>
      </div>

      <!-- Formulario Crear Usuario -->
      <form id="formUsuario" method="POST" class="bg-white p-6 rounded shadow space-y-4 hidden">
        <div class="grid sm:grid-cols-3 gap-6">
          <input type="text" name="nombre" placeholder="Nombre" required class="p-3 border rounded">
          <input type="text" name="apellido" placeholder="Apellido 1" required class="p-3 border rounded">
          <input type="text" name="apellido2" placeholder="Apellido 2" required class="p-3 border rounded">
          <input type="text" name="NIF" placeholder="NIF" required class="p-3 border rounded">
          <input type="text" name="municipio" placeholder="Municipio" required class="p-3 border rounded">
          <input type="text" name="direccion" placeholder="Dirección" required class="p-3 border rounded">
        </div>
        <button type="submit" name="crear_usuario" class="bg-[#216869] text-white px-6 py-2 rounded hover:bg-[#49A078] transition">Crear usuario</button>
      </form>

      <div class="overflow-x-auto bg-white rounded shadow mt-6">
        <table class="min-w-full table-auto border">
          <thead class="bg-[#216869] text-white">
            <tr>
              <th class="p-2">ID</th>
              <th class="p-2">Nombre</th>
              <th class="p-2">Apellidos</th>
              <th class="p-2">NIF</th>
              <th class="p-2">Municipio</th>
              <th class="p-2">Dirección</th>
              <th class="p-2">Acciones</th>
            </tr>
          </thead>
          <tbody class="text-gray-800">
            <?php foreach ($usuarios as $usuario): ?>
              <tr class="border-b">
                <td class="p-2 text-center"><?= $usuario['id'] ?></td>
                <td class="p-2"><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td class="p-2"><?= htmlspecialchars($usuario['apellido'] . ' ' . $usuario['apellido2']) ?></td>
                <td class="p-2"><?= htmlspecialchars($usuario['NIF']) ?></td>
                <td class="p-2"><?= htmlspecialchars($usuario['municipio']) ?></td>
                <td class="p-2"><?= htmlspecialchars($usuario['direccion']) ?></td>
                <td class="p-2 text-center space-x-2">
                  <button onclick="openModal('usuario', <?= $usuario['id'] ?>)" class="text-blue-600 hover:underline">Editar</button>
                  <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                </td>
              </tr>
              <div id="usuario-modal-<?= $usuario['id'] ?>" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white p-8 rounded shadow w-full max-w-xl">
                  <h3 class="text-lg font-semibold mb-6">Editar usuario</h3>
                  <form action="editar_usuario.php" method="POST" class="space-y-4">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" class="w-full border rounded p-3" required>
                      <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" class="w-full border rounded p-3" required>
                      <input type="text" name="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>" class="w-full border rounded p-3" required>
                      <input type="text" name="NIF" value="<?= htmlspecialchars($usuario['NIF']) ?>" class="w-full border rounded p-3" required>
                      <input type="text" name="municipio" value="<?= htmlspecialchars($usuario['municipio']) ?>" class="w-full border rounded p-3" required>
                      <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" class="w-full border rounded p-3" required>
                    </div>
                    <div class="flex justify-end space-x-3">
                      <button type="button" onclick="closeModal('usuario-modal-<?= $usuario['id'] ?>')" class="px-5 py-2 border rounded">Cancelar</button>
                      <button type="submit" class="bg-[#216869] text-white px-6 py-2 rounded hover:bg-[#49A078]">Guardar</button>
                    </div>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- PARQUES -->
<section class="mb-16">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold text-[#292727]">Parques</h2>
    <button onclick="toggleForm('formParque')" class="bg-[#216869] text-white px-4 py-1 rounded hover:bg-[#49A078] transition">+ Nuevo</button>
  </div>

  <!-- Formulario Crear Parque -->
  <form id="formParque" method="POST" class="bg-white p-6 rounded shadow space-y-4 hidden">
    <div class="grid sm:grid-cols-2 gap-6">
      <input type="text" name="nombre_parque" placeholder="Nombre del parque" required class="p-3 border rounded">
      <input type="text" name="identificador" placeholder="Identificador" required class="p-3 border rounded">
      <input type="text" name="ubicacion" placeholder="Ubicación" required class="p-3 border rounded">
      <input type="number" step="0.01" name="potencia_instalada" placeholder="Potencia instalada (kW)" required class="p-3 border rounded">
      <input type="number" step="0.01" name="precio" placeholder="Precio (€)" required class="p-3 border rounded">
    </div>
    <button type="submit" name="crear_parque" class="bg-[#216869] text-white px-6 py-2 rounded hover:bg-[#49A078] transition">Crear parque</button>
  </form>

  <div class="overflow-x-auto bg-white rounded shadow mt-6">
    <table class="min-w-full table-auto border">
      <thead class="bg-[#216869] text-white">
        <tr>
          <th class="p-2">ID</th>
          <th class="p-2">Nombre</th>
          <th class="p-2">Identificador</th>
          <th class="p-2">Ubicación</th>
          <th class="p-2">Potencia (kW)</th>
          <th class="p-2">Precio (€)</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        <?php foreach ($parques as $parque): ?>
          <tr class="border-b">
            <td class="p-2 text-center"><?= $parque['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($parque['nombre']) ?></td>
            <td class="p-2"><?= htmlspecialchars($parque['identificador']) ?></td>
            <td class="p-2"><?= htmlspecialchars($parque['ubicacion']) ?></td>
            <td class="p-2 text-right"><?= $parque['potencia_instalada'] ?></td>
            <td class="p-2 text-right">€<?= number_format($parque['precio'], 2) ?></td>
            <td class="p-2 text-center space-x-2">
              <button onclick="openModal('parque', <?= $parque['id'] ?>)" class="text-blue-600 hover:underline">Editar</button>
              <a href="eliminar_parque.php?id=<?= $parque['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar parque?')">Eliminar</a>
            </td>
          </tr>
          <div id="parque-modal-<?= $parque['id'] ?>" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white p-8 rounded shadow w-full max-w-xl">
              <h3 class="text-lg font-semibold mb-6">Editar parque</h3>
              <form action="editar_parque.php" method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= $parque['id'] ?>">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <input type="text" name="nombre_parque" value="<?= htmlspecialchars($parque['nombre']) ?>" class="w-full border rounded p-3" required>
                  <input type="text" name="identificador" value="<?= htmlspecialchars($parque['identificador']) ?>" class="w-full border rounded p-3" required>
                  <input type="text" name="ubicacion" value="<?= htmlspecialchars($parque['ubicacion']) ?>" class="w-full border rounded p-3" required>
                  <input type="number" step="0.01" name="potencia_instalada" value="<?= $parque['potencia_instalada'] ?>" class="w-full border rounded p-3" required>
                  <input type="number" step="0.01" name="precio" value="<?= $parque['precio'] ?>" class="w-full border rounded p-3" required>
                </div>
                <div class="flex justify-end space-x-3">
                  <button type="button" onclick="closeModal('parque-modal-<?= $parque['id'] ?>')" class="px-5 py-2 border rounded">Cancelar</button>
                  <button type="submit" class="bg-[#216869] text-white px-6 py-2 rounded hover:bg-[#49A078]">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
  </main>
</body>
</html>