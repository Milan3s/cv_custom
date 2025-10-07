
<?php
// ============================
// DESCARGAR PDF (MVC Bridge)
// ============================

// Ruta absoluta al PDF dentro de assets/pdf
$pdfFile = __DIR__ . "/../../../assets/pdf/Curriculum Profesional-David Milanés Moreno.pdf";

// Verificamos que el archivo exista
if (file_exists($pdfFile)) {
    // Configurar headers de descarga
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=\"Curriculum Profesional-David Milanés Moreno.pdf\"");
    header("Content-Length: " . filesize($pdfFile));

    // Limpieza de buffers
    if (ob_get_length()) {
        ob_clean();
    }
    flush();

    // Enviar el archivo
    readfile($pdfFile);
    exit;
} else {
    // Error controlado
    http_response_code(404);
    echo "❌ El archivo no existe en la ruta: " . htmlspecialchars($pdfFile);
    exit;
}
