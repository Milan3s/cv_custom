<?php
// log.php → guarda debug enviado desde JS en log.txt
$data = json_decode(file_get_contents("php://input"), true);
$mensaje = $data["mensaje"] ?? "Sin mensaje";
$info    = $data["data"] ?? null;

$fecha = date("Y-m-d H:i:s");
$rutaLog = __DIR__ . "/log.txt";

$contenido = "[$fecha] $mensaje";
if ($info !== null) {
    $contenido .= " → " . print_r($info, true);
}
$contenido .= "\n";

file_put_contents($rutaLog, $contenido, FILE_APPEND);

echo json_encode(["status" => "ok"]);
