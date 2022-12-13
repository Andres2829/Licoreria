<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-product">
				<div class="card">
					<div class="card-header">
						   Formulario de Producto
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Categoría</label>
								<select name="category_id" id="category_id" class="custom-select select2">
									<option value=""></option>
									<?php
									$qry = $conn->query("SELECT * FROM categories order by name asc");
									while($row=$qry->fetch_assoc()):
										$cname[$row['id']] = ucwords($row['name']);
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Nombre</label>
								<input type="text" class="form-control" name="name">
							</div>
							<div class="form-group">
								<label class="control-label">Descripción</label>
								<textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Precio</label>
								<input type="text" class="form-control text-right" name="price">
							</div>
							<div class="form-group">
								<label class="control-label">Stock</label>
								<input type="number" class="form-control text-right" name="stock">
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="status" name="status" checked value="1">
								  <label class="custom-control-label" for="status">Disponible</label>
								</div>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Guardar</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-product').get(0).reset()"> Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Lista de Productos</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Categoría</th>
									<th class="text-center">Info Producto</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$product = $conn->query("SELECT * FROM products order by id asc");
								while($row=$product->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $cname[$row['category_id']] ?></b></p>
									</td>
									<td class="">
										<p>Nombre: <b><?php echo $row['name'] ?></b></p>
										<p><small>Precio: $<b><?php echo number_format($row['price'],2) ?></b></small></p>
										<p><small>Stock: <b><?php echo $row['stock'] ?></b></small></p>
										<p><small>Estado: <b><?php echo $row['status'] == 1 ? " Available" : "Unavailable" ?></b></small></p>
										<p><small>Descripción: <b><?php echo $row['description'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_product" type="button" data-id="<?php echo $row['id'] ?>" data-description="<?php echo $row['description'] ?>" data-name="<?php echo $row['name'] ?>"  data-price="<?php echo $row['price'] ?>" data-stock="<?php echo $row['stock'] ?>" data-status="<?php echo $row['status'] ?>" data-category_id="<?php echo $row['category_id'] ?>">Editar</button>
										<button class="btn btn-sm btn-danger delete_product" type="button" data-id="<?php echo $row['id'] ?>">Eliminar</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin:unset;
	}
	.custom-switch{
		cursor: pointer;
	}
	.custom-switch *{
		cursor: pointer;
	}
</style>
<script>
	$('#manage-product').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-product').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Datos agregados exitósamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Datos actualizados exitósamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_product').click(function(){
		start_load()
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='stock']").val($(this).attr('data-stock'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id')).trigger('change')
		if($(this).attr('data-status') == 1)
			$('#status').prop('checked',true)
		else
			$('#status').prop('checked',false)
		end_load()
	})
	$('.delete_product').click(function(){
		_conf("Estás segur@ de eliminar este producto","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Datos eliminados exitósamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>