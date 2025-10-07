<?php
// Ruta del archivo PDF (ajústala si el archivo cambia de nombre)
$pdfFile = __DIR__ . "/../../../assets/pdf/Curriculum Profesional-David Milanés Moreno.pdf";

// Verificamos que el archivo exista
if (file_exists($pdfFile)) {
    // Definir headers para forzar descarga
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=\"Curriculum Profesional-David Milanés Moreno.pdf\"");
    header("Content-Length: " . filesize($pdfFile));
    
    // Limpiamos buffer de salida y enviamos el archivo
    ob_clean();
    flush();
    readfile($pdfFile);
    exit;
} else {
    echo "El archivo no existe.";
}
?>
