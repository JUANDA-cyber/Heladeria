<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>

<?php if(isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'complete'): ?>
    <h1>Pedido confirmado</h1>
    <p>Tu pedido ha sido guardado con exito, una vez que realices la transferencia 
    bancariaa la cuenta 34566765767ADD con el costo del pedido, sera procesado y enviado.
    </p>
    <br>

    <?php if(isset($pedido)): ?>
        <h3>Datos del pedido:</h3>
        
        Numero de pedido: <?=$pedido->id?> <br>
        Total a pagar: <?=$pedido->coste?> <br>
        Productos: 
        <table>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Unidades</th>
            </tr>
            <?php while($producto = $productos->fetch_object()): ?>
                <tr>
                    <td>
                        <?php if($producto->imagen != null): ?>
                            <img src="<?=base_url?>uploads/images/<?=$producto->imagen?>" class="img_carrito">
                        <?php else: ?>
                            <img src="<?=base_url?>assets/img/camiseta.png" class="img_carrito">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?=base_url?>producto/ver&id=<?=$producto->id?>"><?=$producto->nombre?></a>
                    </td>
                    <td>
                        <?=$producto->precio?>
                    </td>
                    <td>
                        <?=$producto->unidades?>
                    </td>

                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

<?php elseif(isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'complete'): ?>
    <h1>Tu pedido NO se ha podido procesar</h1>
    <p>realizarlo con un API-REST</p>
<?php endif; ?>
<?php require_once 'views/layout/footer.php'; ?>

