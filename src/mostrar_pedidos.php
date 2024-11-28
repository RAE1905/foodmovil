<?php
session_start();
include_once "includes/header.php";
include "../conexion.php";

// Obtener los pedidos con sus detalles y el nombre del cliente
$sql = "SELECT dp.id_pedido, dp.nombre AS nombre_platillo, dp.cantidad, p.nombre_cliente 
        FROM detalle_pedidos dp 
        INNER JOIN pedidos p ON dp.id_pedido = p.id 
        ORDER BY dp.id_pedido";
$query = mysqli_query($conexion, $sql);

// Verificar si la consulta se ejecutó correctamente
if (!$query) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Agrupar los pedidos por ID del pedido
$pedidos = [];
while ($row = mysqli_fetch_assoc($query)) {
    $id_pedido = $row['id_pedido'];
    $pedidos[$id_pedido]['cliente'] = $row['nombre_cliente'];
    $pedidos[$id_pedido]['detalles'][] = [
        'platillo' => $row['nombre_platillo'],
        'cantidad' => $row['cantidad']
    ];
}
?>

<div class="card">
    <div class="card-header text-center">
        Pedidos
    </div>
    <div class="card-body">
        <?php if (!empty($pedidos)) { ?>
            <div class="table-responsive">
                <?php foreach ($pedidos as $id_pedido => $pedido) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <!--Pedido ID: <?php echo htmlspecialchars($id_pedido); ?>--> Cliente: <?php echo htmlspecialchars($pedido['cliente']); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedido['detalles'] as $detalle) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars($detalle['platillo']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="text-center">No hay pedidos disponibles</p>
        <?php } ?>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>