<?php
// Si entran a procesar.php sin pasar por el formulario, los mandamos al inicio
if ($_SERVER["REQUEST_METHOD"] != "POST") {
  header("Location: index.php");
  exit();
}

// 1) Recibimos los datos. 
$nombre   = trim($_POST['nombre']);   // trim() borra espacios de más 
$correo   = trim($_POST['correo']);
$servicio = $_POST['servicio'];
$mensaje  = trim($_POST['mensaje']);

$ok    = false;         // pasa a true solo si el mail se envía
$clase = "text-danger"; // color del texto: rojo (error) por defecto

// 2) Controles
if (empty($nombre) || empty($correo) || empty($servicio) || empty($mensaje)) { 
  $titulo = "Faltan datos";
  $texto  = "Error: completá todos los campos del formulario.";

} elseif (strtolower($nombre) == "carlos" || strtolower($nombre) == "alberto") { //CONSIGNA DEL TP
  $titulo = "Mensaje no enviado";
  $texto  = "El nombre ingresado no está permitido.";

} else {
  // 3) Armamos y enviamos el mail
  $para      = "info@sitios04.com.ar";
  $asunto    = "Nueva consulta desde Turbo Impresiones";
  $cuerpo    = "Nombre: $nombre\nCorreo: $correo\nServicio: $servicio\nMensaje: $mensaje";
  $cabeceras = "From: web@nexxodigital.com.ar\r\nContent-Type: text/plain; charset=UTF-8"; //no existe este correo lo invente
  if (mail($para, $asunto, $cuerpo, $cabeceras)) {
    $ok     = true;
    $clase  = "text-white";
    $titulo = "¡Mensaje enviado!";
    $texto  = "Gracias por escribirnos. Estos son los datos que recibimos:";
  } else {
    $titulo = "No se pudo enviar";
    $texto  = "Hubo un problema con el envío. Probá de nuevo en unos minutos.";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contacto | Turbo Impresiones</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Racing+Sans+One&display=swap" rel="stylesheet">
  <link href="assets/css/theme.css" rel="stylesheet">
  <link href="assets/css/turbo.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <h1 class="<?php echo $clase; ?>"><?php echo $titulo; ?></h1>
    <p class="lead"><?php echo $texto; ?></p>

    <?php if ($ok) { ?>
      <ul>
        <li><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></li>
        <li><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></li>
        <li><strong>Servicio:</strong> <?php echo htmlspecialchars($servicio); ?></li>
        <li><strong>Mensaje:</strong> <?php echo htmlspecialchars($mensaje); ?></li>
      </ul>
    <?php } ?>

    <a href="index.php#contacto" class="btn btn-primary mt-3">Volver</a>
  </div>
</body>
</html>
