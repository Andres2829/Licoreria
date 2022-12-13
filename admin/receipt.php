<?php 
include 'db_connect.php';
$order = $conn->query("SELECT * FROM orders where id = {$_GET['id']}");
foreach($order->fetch_array() as $k => $v){
	$$k= $v;
}
$items = $conn->query("SELECT o.*,p.name FROM order_items o inner join products p on p.id = o.product_id where o.order_id = $id ");
?>

<style>
	.flex{
		display: inline-flex;
		width: 100%;
	}
	.w-50{
		width: 50%;
	}
	.text-center{
		text-align:center;
	}
	.text-right{
		text-align:right;
	}
	table.wborder{
		width: 100%;
		border-collapse: collapse;
	}
	table.wborder>tbody>tr, table.wborder>tbody>tr>td{
		border:1px solid;
	}
	p{
		margin:unset;
	}

</style>
<div class="container-fluid">
	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "Recibo" : "Bill" ?></b></p>
	<hr>
	<div class="flex">
		<div class="w-100">
			<?php if($amount_tendered > 0): ?>
			<p>Número de Factura: <b><?php echo $ref_no ?></b></p>
		<?php endif; ?>
			<p>Fecha: <b><?php echo date("M d, Y",strtotime($date_created)) ?></b></p>
		</div>
	</div>
	<hr>
	<p><b>Lista de Órdenes</b></p>
	<table width="100%">
		<thead>
			<tr>
				<td><b>QTY</b></td>
				<td><b>Orden</b></td>
				<td class="text-right"><b>Monto</b></td>
			</tr>
		</thead>
		<tbody>
			<?php 
			while($row = $items->fetch_assoc()):
			?>
			<tr>
				<td><?php echo $row['qty'] ?></td>
				<td><p><?php echo $row['name'] ?></p><?php if($row['qty'] > 0): ?><small>(<?php echo number_format($row['price'],2) ?>)</small> <?php endif; ?></td>
				<td class="text-right"><?php echo number_format($row['amount'],2) ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<hr>
	<table width="100%">
		<tbody>
			<tr>
				<td><b>Monto Total</b></td>
				<td class="text-right"><b><?php echo number_format($total_amount,2) ?></b></td>
			</tr>
			<?php if($amount_tendered > 0): ?>


			<tr>
				<td><b>Monto entregado</b></td>
				<td class="text-right"><b><?php echo number_format($amount_tendered,2) ?></b></td>
			</tr>
			<tr>
				<td><b>Cambio</b></td>
				<td class="text-right"><b><?php echo number_format($amount_tendered - $total_amount,2) ?></b></td>
			</tr>
		<?php endif; ?>
			
		</tbody>
	</table>
	<hr>
	<p class="text-center"><b> N Orden</b></p>
	<h4 class="text-center"><b><?php echo $order_number ?></b></h4>
</div>