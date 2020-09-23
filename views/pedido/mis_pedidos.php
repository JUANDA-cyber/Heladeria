<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>


<?php if(isset($gestion)): ?>
    <h1>Gestionar pedidos</h1>
<?php else: ?>
    <h1>Mis pedidos mas</h1>
<?php endif; ?>
<table>
    <tr>
        <th>N° pedido</th>
        <th>Coste</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
    <?php 
        while($ped = $pedidos->fetch_object()): //recorrer el array pedido, y en cada iteracion cree un ped y muestre 
        ?>
        <tr>
            <td>
                <a href="<?=base_url?>pedido/detalle&id=<?=$ped->id?>"><?=$ped->id // se le pasa la id, para especificar los de detalles de que pedido hacerlo?></a>
            </td>
            <td>
                $<?=$ped->coste ?>
            </td>
            <td>
                <?=$ped->fecha?>
            </td>  
            <td>
                <?=Utils::showStatus($ped->estado)?>
            </td> 
        </tr>
    <?php endwhile; ?>
</table>

<?php require_once 'views/layout/footer.php'; ?>

