<?php
require_once 'conectar.php';
$db = new Conectar("localhost", "root", "", "docssisenol");

// Obtener usuarios
$usuarios = $db->recibir_datos("SELECT id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuario");

// Obtener parques
$parques = $db->recibir_datos("SELECT id, nombre FROM parque");
?>

<!-- Formulario -->
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    <form action="" method="POST">
        <!-- Select de usuarios -->
        <label for="usuario_id" class="block text-gray-700 mb-2">Selecciona un usuario:</label>
        <select name="usuario_id" id="usuario_id" class="w-full p-2 border border-gray-300 rounded mb-4" required>
            <option value="">-- Selecciona un usuario --</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nombre_completo']) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Select de parques -->
        <label for="parque_id" class="block text-gray-700 mb-2">Selecciona un parque:</label>
        <select name="parque_id" id="parque_id" class="w-full p-2 border border-gray-300 rounded mb-4" required>
            <option value="">-- Selecciona un parque --</option>
            <?php foreach ($parques as $parque): ?>
                <option value="<?= $parque['id'] ?>"><?= htmlspecialchars($parque['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

<!-- Fecha de entrega -->
<label for="fecha_entrega" class="block text-gray-700 mb-2">Fecha de entrega de equipos:</label>
<input type="date" name="fecha_entrega" id="fecha_entrega" class="w-full p-2 border border-gray-300 rounded mb-4" required>

<!-- Fecha de firma -->
<label for="fecha_firma" class="block text-gray-700 mb-2">Fecha de firma del acta conforme:</label>
<input type="date" name="fecha_firma" id="fecha_firma" class="w-full p-2 border border-gray-300 rounded mb-4" required>

<!-- Juzgado -->
<label for="juzgado" class="block text-gray-700 mb-2">Juzgado para litigios:</label>
<input type="text" name="juzgado" id="juzgado" placeholder="Ej. Madrid, Parla..." class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <!-- Botón de enviar -->
        <button type="submit" name="enviar" class="bg-black text-white px-4 py-2 rounded hover:bg-[#49A078] transition duration-300">
            Enviar
        </button>
    </form>
</div>

<!-- Incluir procesamiento si se ha enviado el formulario -->
<?php
if (isset($_POST['enviar'])) {
    include 'documento.php';
}
?>
