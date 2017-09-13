<?php
	if (!isConnect()) {
		throw new Exception('{{401 - Accès non autorisé}}');
	}
	$eqLogics = eqLogic::byType('CaveVin');
?>
<div style="position : fixed;height:100%;width:15px;top:50px;left:0px;z-index:998;background-color:#f6f6f6;" id="bt_displayObjectList">
	<i class="fa fa-arrow-circle-o-right" style="color : #b6b6b6;"></i>
</div>
<div class="row row-overflow" id="div_mesVin">
	<div class="col-xs-2" id="sd_objectList" style="z-index:999">
		<div class="bs-sidebar">
			<ul id="ul_object" class="nav nav-list bs-sidenav">
				<li class="nav-header">{{Ma cave a vin}}</li>
				<?php
					foreach ($eqLogics as $eqLogic) {
						echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName() . '</a></li>';
					}
				?>
			</ul>
		</div>
	</div>

	<div class="col-xs-10" id="div_graphiqueDisplay">
		<legend style="height: 40px;">
			<form class="form-inline" role="form" onsubmit="return false;">
				<div class="form-group">
					<div class="btn-group Track">
						<a class="btn btn-default bt_VinFilter btn-primary" data-filtre="met">Type de plat</a>
					</div>
				</div>
				<div class="form-group" id="in_search" >
					<input class="form-control text_search" placeholder="Rechercher">
					<a class="btn btn-success" id="bt_search"><i class="fa fa-search"></i></a>
				</div>
				<div class="form-group">
					<a class="btn btn-success mesVinAction" data-action="new"><i class="fa fa-check-circle"></i> {{Ajouter}}</a>
				</div>
				<div class="form-group">
					<a class="btn btn-success mesVinAction" data-action="update"><i class="fa fa-check-circle"></i> {{Modifier}}</a>
				</div>
				<div class="form-group">
					<a class="btn btn-warning mesVinAction" data-action="exporter"><i class="fa fa-check-circle"></i> {{Exporter}}</a>
				</div>
				<!--div class="form-group">
					<a class="btn btn-primary mesVinAction" data-action="importer"><i class="fa fa-check-circle"></i> {{Importer}}</a>
				</div-->
			</form>
		</legend>
		<div class="row">
			<div class="col-lg-6">
				<legend>{{Mon casier}}</legend>
				<div class="widgetDisplay" style="height: 500px;overflow-y: scroll;"></div>
			</div>
			<div class="col-lg-6">
				<legend>{{Ma liste de vin}}</legend>
				<div class='FiltreVinDisplay' style="height: 500px;overflow-y: scroll;"></div>
			</div>
			<div class="col-lg-6">
				<legend>{{Fiche vin}}</legend>
				<div class='FicheVinDisplay' style="height: 500px;overflow-y: scroll;"></div>
			</div>
		</div>
	</div>
</div>
<?php include_file('desktop', 'panel', 'js', 'CaveVin');?>
