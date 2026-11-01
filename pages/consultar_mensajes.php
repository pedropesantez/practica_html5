<?php
require_once "conexion.php";

$sql = "SELECT id_mensaje, nombre_completo, correo_electronico, asunto, mensaje, fecha_registro 
        FROM mensajes_contacto 
        ORDER BY fecha_registro DESC, id_mensaje DESC";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Mensajes - Universo Musical</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <div id="contenedor-principal">
        <header id="cabecera-sitio">
            <h1>Bandeja de Mensajes Recibidos</h1>
            <p class="subtitulo-cabecera">Consulta en tiempo real de los registros almacenados en MySQL.</p>
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
                <section class="bloque-seccion">
                    <h2>Listado de Mensajes de Contacto</h2>

                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <p>Total de mensajes registrados: <strong><?php echo $resultado->num_rows; ?></strong></p>

                        <table id="tabla-mensajes">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Correo Electrónico</th>
                                    <th>Asunto</th>
                                    <th>Mensaje</th>
                                    <th>Fecha de Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($fila = $resultado->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila["id_mensaje"], ENT_QUOTES, "UTF-8"); ?></td>
                                        <td><?php echo htmlspecialchars($fila["nombre_completo"], ENT_QUOTES, "UTF-8"); ?></td>
                                        <td><?php echo htmlspecialchars($fila["correo_electronico"], ENT_QUOTES, "UTF-8"); ?></td>
                                        <td><?php echo htmlspecialchars($fila["asunto"], ENT_QUOTES, "UTF-8"); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($fila["mensaje"], ENT_QUOTES, "UTF-8")); ?></td>
                                        <td><?php echo htmlspecialchars($fila["fecha_registro"], ENT_QUOTES, "UTF-8"); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="nota-curiosa">
                            <h3>Sin registros disponibles</h3>
                            <p>Actualmente <strong>no existen mensajes registrados</strong> en la base de datos. Puedes enviar el primero desde la sección de <a href="contacto.html">Contacto</a>.</p>
                        </div>
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
<?php
$conexion->close();
?>