<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    require_once "../conexion.php";
    
    if (isset($_GET['id'])) {
        $id_pedido = $_GET['id'];
        $query = mysqli_query($conexion, "SELECT * FROM pedidos WHERE id = $id_pedido");
        $pedido = mysqli_fetch_assoc($query);
    }

    if (isset($_POST['cancelar'])) {
        $id_pedido = $_POST['id_pedido'];
        $query = mysqli_query($conexion, "UPDATE pedidos SET estado = 'CANCELADO' WHERE id = $id_pedido");
        header("Location: lista_ventas.php");
    }

    include_once "includes/header.php";
?>
    <div class="card">
        <div class="card-header">
            Editar Pedido
        </div>
        <div class="card-body">
            <form action="editar_pedido.php" method="POST">
                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id']; ?>">
                <div class="form-group">
                    <label for="sala">Sala</label>
                    <input type="text" class="form-control" name="sala" value="<?php echo $pedido['id_sala']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="mesa">Mesa</label>
                    <input type="text" class="form-control" name="mesa" value="<?php echo $pedido['num_mesa']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="text" class="form-control" name="fecha" value="<?php echo $pedido['fecha']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" class="form-control" name="total" value="<?php echo $pedido['total']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select class="form-control" name="estado">
                        <option value="PENDIENTE" <?php if ($pedido['estado'] == 'PENDIENTE') echo 'selected'; ?>>Pendiente</option>
                        <option value="COMPLETADO" <?php if ($pedido['estado'] == 'COMPLETADO') echo 'selected'; ?>>Completado</option>
                        <option value="CANCELADO" <?php if ($pedido['estado'] == 'CANCELADO') echo 'selected'; ?>>Cancelado</option>
                    </select>
                </div>
                <button type="submit" name="cancelar" class="btn btn-danger">Cancelar Pedido</button>
            </form>
        </div>
    </div>
<?php include_once "includes/footer.php"; 
} else {
    header('Location: permisos.php');
}
?>
