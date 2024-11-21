<?php
session_start();
include_once "includes/header.php";
include "../conexion.php";

// Obtener los pedidos
$query = mysqli_query($conexion, "SELECT dp.id_pedido, dp.nombre AS nombre_platillo, dp.precio, dp.cantidad, p.fecha 
                                   FROM detalle_pedidos dp 
                                   INNER JOIN pedidos p ON dp.id_pedido = p.id 
                                   ORDER BY dp.id_pedido, dp.nombre");

?>

<div class="card">
    <div class="card-header text-center">
        Pedidos
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Nombre del Platillo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Fecha del Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                    <td>{$row['id_pedido']}</td>
                                    <td>{$row['nombre_platillo']}</td>
                                    <td>{$row['precio']}</td>
                                    <td>{$row['cantidad']}</td>
                                    <td>{$row['fecha']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay pedidos disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>

