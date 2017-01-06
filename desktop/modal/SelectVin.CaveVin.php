<?php
if (!isConnect('admin')) {
    throw new Exception('401 Unauthorized');
}
include_file('core', 'mesVin', 'class', 'CaveVin');
?>
<table class="ListeMesVin table table-bordered table-condensed tablesorter" style="height: 500px;overflow-y: scroll;">
	<thead>
		<tr>
			<th>{{Nom}}</th>
			<th>{{Cepage}}</th>
			<th>{{Millesime}}</th>
			<th>{{Quantité}}</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
<script>
var Vin='';
var Filtre='';
UpdateListVin()
initTableSorter();
$('.ListeMesVin tr').on( 'click', function() {	
	getVinInformation($(this).attr('data_id'));
});
$('body').on( 'click','#bt_search', function() {	
	UpdateListVin();
}); 
$('body').on( 'click','.bt_VinFilter', function() {		
	$('.btn-primary').removeClass('btn-primary');
	Filtre=$(this).attr("data-filtre");
	$(this).addClass('btn-primary');
});
function UpdateListVin(){	
	$.ajax({
		type: 'POST',            
		async: false,
		url: 'plugins/CaveVin/core/ajax/CaveVin.ajax.php',
		data:
			{
			action: 'getFiltreVins',
			Filtre:Filtre,
			search:$('.text_search').val(),
			},
		dataType: 'json',
		global: false,
		error: function(request, status, error) {
		},
		success: function(data) {
			$('.ListeMesVin tbody').html('');
			jQuery.each(data.result,function(key,Vin) {
				if($('.Vin[data_id='+Vin.id+']').length ==0){
					$('.ListeMesVin tbody').append(
						$('<tr>').addClass('Vin').attr('data_id',Vin.id)
							.append($('<td>').text(Vin.Nom))
							.append($('<td>').text(Vin.Cepage))
							.append($('<td>').text(Vin.Millesime))
							.append($('<td>').text(Vin.QtsTypeVin)));		
					$('.ListeMesVin').trigger('update');
				}
			});
		}
	});
}
</script>
