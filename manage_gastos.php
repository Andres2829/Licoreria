<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-gastos">
				<div class="card">
					<div class="card-header">
						    Registro de Gastos Diarios
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Gasto</label>
								<input type="text" class="form-control" name="tgasto">
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion</label>
								<textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control"></textarea>
							</div>
                            <div class="form-group">
								<label class="control-label">Total</label>
								<input type="text" class="form-control" name="total">
							</div>
						
                            

					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Guardar</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-gastos').get(0).reset()"> Cancelar</button>
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
						<b>Lista de Gastos </b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Información Gastos</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$gast = $conn->query("SELECT * FROM gastos order by id asc");
								while($row=$gast->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Gasto: <b><?php echo $row['tgasto'] ?></b></p>
										<p><small>Descripcion: <b><?php echo $row['observacion'] ?></b></small></p>
                                        <p><small>Total: <b><?php echo $row['total'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_gastos" type="button" data-id="<?php echo $row['id'] ?>" data-description="<?php echo $row['observacion'] ?>" data-name="<?php echo $row['tgasto'] ?>" data-total="<?php echo $row['total'] ?>" >Editar</button>
										<button class="btn btn-sm btn-danger delete_gasto" type="button" data-id="<?php echo $row['id'] ?>">Eliminar</button>
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
</style>
<script>
	$('#manage-gastos').on('reset',function(){
		$('input:hidden').val('')
	})
	
	$('#manage-gastos').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_gasto',
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
					alert_toast("Datos agregados exitósamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_gastos').click(function(){
		start_load()
		var cat = $('#manage-gastos')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='tgasto']").val($(this).attr('data-name'))
		cat.find("[name='observacion']").val($(this).attr('data-description'))
        cat.find("[name='total']").val($(this).attr('data-total'))
		end_load()
	})
	$('.delete_gasto').click(function(){
		_conf("¿Estás segur@ de eliminar esta categoría?","delete_gasto",[$(this).attr('data-id')])
	})
	function delete_gasto($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_gasto',
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