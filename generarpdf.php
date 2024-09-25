<?php
require('fpdf186/fpdf.php'); // Asegúrate de que la ruta es correcta

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$nivel = $_SESSION['nivel'];

if ($nivel < 1 || $nivel > 3) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "192005";
$dbname = "activos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM eterna";
$result = $conn->query($sql);

$pdf = new FPDF('L', 'mm', 'A4'); // Cambiar a orientación horizontal
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10); // Cambiar el tamaño de la fuente

// Colores
$headerColor = [205,83,40,255]; // Color de fondo naranja para los encabezados (rgb)
$rowColor = [255, 255, 255]; // Color de fondo gris claro para las filas (rgb)
$alternateRowColor = [255, 255, 255]; // Color de fondo alternativo (rgb)

$pdf->SetFillColor(...$headerColor); // Color de fondo para encabezados
$pdf->SetTextColor(255, 255, 255); // Color de texto blanco

$pdf->Cell(15, 10, 'Cat', 1, 0, 'C', true); // Cambiar el nombre a "Cat"
$pdf->Cell(20, 10, 'Codigo', 1, 0, 'C', true);
$pdf->Cell(100, 10, 'Descripcion Activo', 1, 0, 'C', true); // Ampliado
$pdf->Cell(45, 10, 'Serie', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'Ubicacion', 1, 0, 'C', true); // Ampliado
$pdf->Cell(20, 10, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Pais', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0); // Restablecer el color de texto a negro para las filas

$pdf->SetFillColor(...$rowColor); // Restablecer a gris claro para filas
$pdf->SetFont('Arial', '', 9); // Cambiar a un tamaño de fuente más pequeño

if ($result->num_rows > 0) {
    $isAlternate = false; // Para filas alternas

    while ($row = $result->fetch_assoc()) {
        if ($isAlternate) {
            $pdf->SetFillColor(...$alternateRowColor); // Color de fila alternativo
        } else {
            $pdf->SetFillColor(...$rowColor); // Color de fondo gris claro
        }

        $pdf->Cell(15, 10, $row['Categoria'], 1, 0, 'C', true); // Cambiar a "Cat"
        $pdf->Cell(20, 10, $row['Codigo'], 1, 0, 'C', true);
        $pdf->Cell(100, 10, $row['Activo'], 1, 0, 'C', true); // Ampliado
        $pdf->Cell(45, 10, $row['Serie'], 1, 0, 'C', true);
        $pdf->Cell(55, 10, $row['Ubicacion'], 1, 0, 'C', true); // Ampliado
        $pdf->Cell(20, 10, $row['Fecha'], 1, 0, 'C', true);
        $pdf->Cell(20, 10, $row['Pais'], 1, 1, 'C', true);

        // Alternar color de fila
        $isAlternate = !$isAlternate;

        // Controla el salto de página si es necesario
        if ($pdf->GetY() > 250) { // Cambia a la altura necesaria
            $pdf->AddPage('L'); // Añadir nueva página en horizontal
            $pdf->SetFont('Arial', 'B', 10);
            // Reimprimir encabezados
            $pdf->SetFillColor(...$headerColor);
            $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
            $pdf->Cell(15, 10, 'Cat', 1, 0, 'C', true);
            $pdf->Cell(20, 10, 'Codigo', 1, 0, 'C', true);
            $pdf->Cell(100, 10, 'Descripcion Activo', 1, 0, 'C', true); // Ampliado
            $pdf->Cell(45, 10, 'Serie', 1, 0, 'C', true);
            $pdf->Cell(55, 10, 'Ubicacion', 1, 0, 'C', true); // Ampliado
            $pdf->Cell(20, 10, 'Fecha', 1, 0, 'C', true);
            $pdf->Cell(20, 10, 'Pais', 1, 1, 'C', true);
            $pdf->SetTextColor(0, 0, 0); // Restablecer el color de texto a negro
            $pdf->SetFillColor(...$rowColor); // Color de fondo gris claro para las celdas de datos
        }
    }
} else {
    $pdf->Cell(0, 10, 'No se encontraron registros.', 0, 1, 'C');
}

$pdf->Output('D', 'activos.pdf');
$conn->close();
?>











