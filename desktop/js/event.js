$('body').on('CaveVin::change', function (_event,_options) {
		var cmd = _options;
		if(cmd.configuration.filter_page != 'all' && window.location.href.indexOf('p='+cmd.configuration.filter_page) < 0){
			return;
		}
		if(cmd.configuration.filter_user != 'all' && user_id != cmd.configuration.filter_user){
			return;
		}
		if(cmd.configuration.filter_interface != 'all' && cmd.configuration.filter_interface != 'desktop'){
			return;
		}
			$('#md_modal').dialog({title: cmd.name});
			$('#md_modal').attr('data-clink',cmd.eqLogic_id);
			$('#md_modal').load('index.php?v=d&plugin=CaveVin&modal=mouvement.CaveVin').dialog('open');
			
});
