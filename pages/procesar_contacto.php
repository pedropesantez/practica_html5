<?php
require_once "conexion.php";

$errores = [];
$registro_exitoso = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir entradas sin recortar primero para detectar si solo enviaron espacios
    $nombre_raw  = isset($_POST["nombre_completo"]) ? $_POST["nombre_completo"] : "";
    $correo_raw  = isset($_POST["correo_electronico"]) ? $_POST["correo_electronico"] : "";
    $asunto_raw  = isset($_POST["asunto"]) ? $_POST["asunto"] : "";
    $mensaje_raw = isset($_POST["mensaje"]) ? $_POST["mensaje"] : "";

    // Limpiar espacios al inicio y al final
    $nombre  = trim($nombre_raw);
    $correo  = trim($correo_raw);
    $asunto  = trim($asunto_raw);
    $mensaje = trim($mensaje_raw);

    // 1. Validación de Nombre Completo (obligatorio, no solo espacios, máx. 100)
    if ($nombre === "") {
        $errores[] = "El campo 'Nombre completo' es obligatorio y no puede estar vacío ni contener solo espacios.";
    } elseif (mb_strlen($nombre, "UTF-8") > 100) {
        $errores[] = "El campo 'Nombre completo' supera el límite máximo de 100 caracteres (ingresados: " . mb_strlen($nombre, "UTF-8") . ").";
    }

    // 2. Validación de Correo Electrónico (obligatorio, máx. 150, formato válido)
    if ($correo === "") {
        $errores[] = "El campo 'Correo electrónico' es obligatorio y no puede estar vacío ni contener solo espacios.";
    } elseif (mb_strlen($correo, "UTF-8") > 150) {
        $errores[] = "El campo 'Correo electrónico' supera el límite máximo de 150 caracteres (ingresados: " . mb_strlen($correo, "UTF-8") . ").";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El 'Correo electrónico' ingresado no tiene un formato válido (ejemplo válido: nombre@dominio.com).";
    }

    // 3. Validación de Asunto (obligatorio, no solo espacios, máx. 150)
    if ($asunto === "") {
        $errores[] = "El campo 'Asunto' es obligatorio y no puede estar vacío ni contener solo espacios.";
    } elseif (mb_strlen($asunto, "UTF-8") > 150) {
        $errores[] = "El campo 'Asunto' supera el límite máximo de 150 caracteres (ingresados: " . mb_strlen($asunto, "UTF-8") . ").";
    }

    // 4. Validación de Mensaje (obligatorio, no solo espacios, máx. 2000)
    if ($mensaje === "") {
        $errores[] = "El campo 'Mensaje' es obligatorio y no puede estar vacío ni contener solo espacios.";
    } elseif (mb_strlen($mensaje, "UTF-8") > 2000) {
        $errores[] = "El campo 'Mensaje' supera el límite máximo de 2000 caracteres (ingresados: " . mb_strlen($mensaje, "UTF-8") . ").";
    }

    // 5. Si no existen errores de validación, insertar mediante consulta preparada
    if (empty($errores)) {
        $sql = "INSERT INTO mensajes_contacto (nombre_completo, correo_electronico, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
            if ($stmt->execute()) {
                $registro_exitoso = true;
            } else {
                $errores[] = "Error al guardar el mensaje en la base de datos: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errores[] = "Error al preparar la consulta SQL: " . $conexion->error;
        }
    }
} else {
    $errores[] = "Acceso no válido. El formulario debe enviarse mediante el método POST.";
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Envío - Universo Musical</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <div id="contenedor-principal">
        <header id="cabecera-sitio">
            <h1>Procesamiento de Mensaje de Contacto</h1>
            <p class="subtitulo-cabecera">Estado de validación y almacenamiento en el servidor.</p>
        </header>

        <div class="layout-columnas">
            <nav id="menu-navegacion">
                <h2>Navegación</h2>
                <ul>
                    <li><a href="../index.html">Inicio</a></li>
                    <li><a href="bajo.html">El Bajo Eléctrico</a></li>
                    <li><a href="guitarra.html">La Guitarra Eléctrica</a></li>
                    <li><a href="bateria.html">La Batería</a></li>
                    <li><a href="teclados.html">Teclados y Sintetizadores</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="consultar_mensajes.php">Consultar Mensajes</a></li>
                </ul>
            </nav>

            <main id="contenido-principal">
                <section id="mensaje-estado" class="bloque-seccion">
                    <?php if ($registro_exitoso): ?>
                        <div class="alerta-exito">
                            <h2>¡Mensaje registrado con éxito!</h2>
                            <p>Tu mensaje ha superado todas las validaciones y se ha guardado correctamente en la base de datos MySQL.</p>
                            <p><strong>Resumen de datos almacenados:</strong></p>
                            <ul class="lista-contenido-ul">
                                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Correo:</strong> <?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Asunto:</strong> <?php echo htmlspecialchars($asunto, ENT_QUOTES, 'UTF-8'); ?></li>
                            </ul>
                        </div>
                        <p>
                            <a href="consultar_mensajes.php">Ir a Consultar Mensajes Registrados</a> |
                            <a href="contacto.html">Enviar otro mensaje</a>
                        </p>
                    <?php else: ?>
                        <div class="alerta-error">
                            <h2>No se pudo registrar el mensaje</h2>
                            <p>Se detectaron los siguientes errores durante la validación en el servidor (el registro no fue almacenado):</p>
                            <ul class="lista-contenido-ul">
                                <?php foreach ($errores as $error): ?>
                                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <p><a href="contacto.html">Volver al formulario de contacto</a></p>
                    <?php endif; ?>
                </section>
            </main>
        </div>

        <footer id="pie-pagina">
            <p>Desarrollado por: <strong>Pedro Xavier Pesántez Urgilés</strong></p>
            <p>Contacto: <a href="mailto:ppesantezu@est.ups.edu.ec">ppesantezu@est.ups.edu.ec</a></p>
            <p>&copy; 2026 Pedro Pesántez. Todos los derechos reservados.</p>
        </footer>
    </div>

</body>
</html>