<?php
include('../app/config.php');
include('../layout/admin/datos_usuario_sesion.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('../layout/admin/head.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../layout/admin/menu.php'); ?>
        <div class="content-wrapper">
            <br>
            <div class="container">

                <h2>Listado de espacios</h2>
                <br>

                <script>
                    $(document).ready(function () {
                        $('#table_id').DataTable({
                            "pageLength": 5,
                            "language": {
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Espacios",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Espacios",
                                "infoFiltered": "(Filtrado de _MAX_ total Espacios)",
                                "lengthMenu": "Mostrar _MENU_ Espacios",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscador:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Último",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                }
                            }
                        });
                    });
                </script>

                <div class="row">
                    <div class="col-md-8">
                        <table id="table_id" class="table table-bordered table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Nro</center>
                                    </th>
                                    <th>Nro espacio</th>
                                    <th>
                                        <center>Acción</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query_mapeos = $pdo->prepare("SELECT * FROM tb_mapeos WHERE estado = '1'");
                                $query_mapeos->execute();
                                $mapeos = $query_mapeos->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($mapeos as $mapeo) {
                                    $id_map = $mapeo['id_map'];
                                    $nro_espacio = $mapeo['nro_espacio'];
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td>
                                            <center><?php echo $contador; ?></center>
                                        </td>
                                        <td><?php echo $nro_espacio; ?></td>
                                        <td>
                                            <center>
                                                <!-- ✅ Botón con clase y data-id -->
                                                <a href="#" class="btn btn-danger btn-borrar"
                                                    data-id="<?php echo $id_map; ?>">
                                                    Borrar
                                                </a>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="respuesta"></div> <!-- Aquí se muestra la respuesta del servidor -->

                <hr>
                <a href="#" class="btn btn-primary" onclick="abrirRecibo(event)">
                    Generar reporte
                    <i class="fa fa">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                            <path
                                d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z" />
                            <path
                                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                    </i>
                </a>

                <script>
                    function abrirRecibo(event) {
                        event.preventDefault(); // evita que el <a> recargue la página
                        window.open(
                            'generar-reporte.php',        // 👉 ruta al archivo que genera el PDF
                            'ventanaRecibo',              // nombre de la ventana
                            'width=400,height=600,scrollbars=no,resizable=no' // tamaño y opciones
                        );
                    }
                </script>

            </div>
        </div>

        <?php include('../layout/admin/footer.php'); ?>
    </div>
    <?php include('../layout/admin/footer_link.php'); ?>

    <!-- ✅ SCRIPT FINAL: AJAX para eliminar -->
    <script>
        $(document).on('click', '.btn-borrar', function (e) {
            e.preventDefault();

            let id_map = $(this).data('id');

            if (!confirm("¿Seguro que deseas eliminar este espacio?")) return;

            $.get('controller_delete.php', { id_map: id_map }, function (datos) {
                $('#respuesta').html(datos);
                location.reload(); // recarga para ver el cambio
            }).fail(function () {
                alert("❌ Error al conectar con el servidor.");
            });
        });
    </script>

</body>

</html>