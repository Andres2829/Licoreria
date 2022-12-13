<div class="container-fluid py-1">
	<?php include 'receipt.php' ?>
</div>
<div class="modal-footer row display py-1">
		<div class="col-lg-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
			<button class="btn float-right btn-success mr-2" type="button" id="print">Imprimir</button>
		</div>
</div>

<script>

	$('#print').click(function(){
		start_load()
		var nw = window.open('receipt.php?id=<?php echo $_GET['id'] ?>',"_blank","width=900,height=600")
		setTimeout(function(){
			nw.print()
			setTimeout(function(){
				nw.close()
				end_load()
			},500)
		},500)
	});
	
</script>