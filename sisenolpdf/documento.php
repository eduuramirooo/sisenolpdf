<?php
require_once 'conectar.php';

$db = new Conectar("localhost", "root", "", "docssisenol");

if (!isset($_POST['usuario_id'], $_POST['parque_id'], $_POST['juzgado'], $_POST['fecha_entrega'], $_POST['fecha_firma'])) {
    die("Faltan datos para generar el contrato.");
}

$usuario_id = $_POST['usuario_id'];
$parque_id = $_POST['parque_id'];
$juzgado = $_POST['juzgado'];
$fecha_entrega = $_POST['fecha_entrega'];
$fecha_firma = $_POST['fecha_firma'];

// Datos del usuario (comprador)
$usuario = $db->hacer_consulta_resultado(
    "SELECT nombre, apellido, apellido2, NIF, municipio, direccion FROM usuario WHERE id = ?",
    "i",
    [$usuario_id]
)[0];

// Datos del parque
$parque = $db->hacer_consulta_resultado(
    "SELECT nombre, identificador, ubicacion, potencia_instalada, precio FROM parque WHERE id = ?",
    "i",
    [$parque_id]
)[0];

// Vendedor ficticio
$vendedor = [
    "nombre" => "Juan Pérez",
    "NIF" => "11111111A",
    "direccion" => "Calle Falsa 123, Madrid"
];

// Fecha actual
$fecha = date('d') . " de " . date('F') . " de " . date('Y');
$hora = date('H:i');

// Cálculo de seguro y garantía
$fecha_entrega_obj = new DateTime($fecha_entrega);
$entrega_plus_24 = clone $fecha_entrega_obj;
$entrega_plus_24->modify('+24 months');

$fecha_firma_obj = new DateTime($fecha_firma);
$firma_plus_28 = clone $fecha_firma_obj;
$firma_plus_28->modify('+28 months');

$fecha_seguro_obj = ($entrega_plus_24 < $firma_plus_28) ? $entrega_plus_24 : $firma_plus_28;
$fecha_seguro = $fecha_seguro_obj->format('d/m/Y');

$fecha_garantia = ($fecha_entrega_obj < $fecha_firma_obj) ? $entrega_plus_24 : $firma_plus_28;
$fecha_garantia_str = $fecha_garantia->format('d/m/Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Compraventa</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="flex justify-center mb-4 no-print">
        <button onclick="descargarPDF()" class="bg-black text-white px-4 py-2 rounded hover:bg-[#49A078] transition duration-300 mt-4">
            Descargar PDF
        </button>
    </div>

    <div id="contrato" class="bg-white max-w-3xl mx-auto p-4 shadow rounded text-sm leading-6 text-gray-800">
        <!-- Encabezado -->
        <div class="flex items-center mb-6">
            <img src="img/logo.png" alt="Logo" class="h-12 w-auto mr-4">
            <h1 class="text-2xl font-bold">Sisenol Solutions</h1>
        </div>

        <h2 class="text-center text-xl font-bold mb-6">Contrato de Compraventa de Parque</h2>

        <p class="mb-2">En Madrid, a <?= $fecha ?></p>
        <p class="mb-6 font-semibold">Nº de contrato cliente <?= $parque_id ?><?= $usuario_id ?></p>

        <p class="mb-2"><strong>Vendedor:</strong><br>
        D. <?= $vendedor['nombre'] ?>, con N.I.F. nº <?= $vendedor['NIF'] ?>,<br>
        domicilio en <?= $vendedor['direccion'] ?>.</p>

        <p class="mb-4"><strong>Comprador:</strong><br>
        D. <?= $usuario['nombre'] . " " . $usuario['apellido'] . " " . $usuario['apellido2'] ?>, con N.I.F. nº <?= $usuario['NIF'] ?>,<br>
        domicilio en <?= $usuario['direccion'] ?>, <?= $usuario['municipio'] ?>.</p>

        <p class="mb-4"><strong>Parque:</strong><br>
        Nombre: <?= $parque['nombre'] ?><br>
        Identificador: <?= $parque['identificador'] ?><br>
        Ubicación: <?= $parque['ubicacion'] ?><br>
        Potencia instalada: <?= $parque['potencia_instalada'] ?> kW</p>

        <p class="mb-4">Reunidos vendedor y comprador en la fecha del encabezado manifiestan haber acordado formalizar en este documento <strong>CONTRATO DE COMPRAVENTA</strong> del parque que se especifica, en las siguientes condiciones:</p>

        <ol class="list-decimal list-inside space-y-2 mb-6">
            <li>El vendedor vende al comprador el parque por <strong><?= number_format($parque['precio'], 2) ?> euros</strong>, sin incluir impuestos.</li>
            <li>El vendedor declara que el parque no tiene cargas ni deudas, y se compromete a resolverlas si existieran.</li>
            <li>El vendedor entregará toda la documentación necesaria, a cargo del comprador.</li>
            <li>Tras la transferencia, el comprador asume toda responsabilidad sobre el parque.</li>
            <li>El parque dispone de seguro en vigor hasta fecha de <strong><?= $fecha_seguro ?></strong> y está al corriente en ITP.</li>
            <li>La garantía de la instalación y los productos suministrados por SISENOL será válida hasta el <strong><?= $fecha_garantia_str ?></strong>, que corresponde al menor plazo entre 28 meses desde la entrega de los equipos o 24 meses desde la firma conforme del acta.</li>
            <li>El comprador acepta el estado del parque y exonera al vendedor de defectos futuros salvo dolo.</li>
            <li>Para litigios, ambas partes se someten a los juzgados de <strong><?= htmlspecialchars($juzgado) ?></strong>.</li>
        </ol>

        <p class="mb-8">Y para que así conste, firman el presente contrato de compraventa, por triplicado, en la fecha y lugar arriba indicados.</p>

        <div class="flex justify-between mt-10">
            <div class="text-center">
                ___________________________<br>
                Firma del Vendedor
            </div>
            <div class="text-center">
                ___________________________<br>
                Firma del Comprador
            </div>
        </div>
    </div>

<script>
    const nombreParque = <?= json_encode($parque['nombre']) ?>;

    function toCamelCase(str) {
        return str
            .replace(/[^a-zA-Z0-9 ]/g, '') // quitar caracteres especiales
            .split(' ')
            .map((word, index) => {
                const lower = word.toLowerCase();
                return index === 0 ? lower : lower.charAt(0).toUpperCase() + lower.slice(1);
            })
            .join('');
    }

    function descargarPDF() {
        window.scrollTo(0, 0);

        const nombreParqueCamel = toCamelCase(nombreParque);
        const elemento = document.getElementById("contrato");

        const opt = {
            margin: [0, 0, 0, 0],
            filename: `ContratoCompraVenta${nombreParqueCamel}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, scrollY: 0 },
            jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(elemento).save();
    }
</script>
</body>
</html>
