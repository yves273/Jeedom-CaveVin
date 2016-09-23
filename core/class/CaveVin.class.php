<?php

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
include_file('core', 'mesVin', 'class', 'CaveVin');
class CaveVin extends eqLogic {
	public static function AddCommande($eqLogic,$Name) {
		$Commande = CaveVinCmd::byEqLogicIdCmdName($eqLogic->getId(),$Name);//$eqLogic->getCmd(null,$_logicalId);
		if (!is_object($Commande))
		{
			$Commande = new CaveVinCmd();
			$Commande->setId(null);
			$Commande->setEqLogic_id($eqLogic->getId());
			$Commande->setType("info");
			$Commande->setSubType("binary");
			$Commande->setName($Name);
			$Commande->setTemplate('dashboard','Bouteille');
			$Commande->setTemplate('mobile','Bouteille');
			$Commande->setEventOnly(true);
			$Commande->setIsVisible(true);
			$Commande->save();
		}
		return $Commande;
	}
	public static function DemonGPIO($_option) {
		$eqLogic=eqLogic::byId($_option['id']);
		for($widthCase=1;$widthCase<=$eqLogic->getConfiguration('widthCase');$widthCase++){
			//Activer la ligne GPIO $widthCase
			switch($widthCase){
				case 1:
					$CurentGpio=0;
					$OldGpio=$eqLogic->getConfiguration('widthCase')-1;
				break;
				case $eqLogic->getConfiguration('widthCase'):
					$OldGpio=$widthCase-1;
					$CurentGpio=0;
				break;
				default:
					$CurentGpio=$widthCase-1;
					$OldGpio=$widthCase-2;
				break;
			}
			self::setPinState($OldGpio,0);
			self::setPinState($CurentGpio,1);
			for($heightCase=1;$heightCase<=$eqLogic->getConfiguration('heightCase');$heightCase++){
				//Lire la ligne GPIO $heightCase
				$Commande=cmd::byLogicalId($eqLogic->getName().'_'.$widthCase."x".$heightCase)[0];
				if (is_object($Commande))
				{
					$Commande->setCollectDate('');
					$Commande->event(self::getPinState($eqLogic->getConfiguration('widthCase')+$heightCase));
					$Commande->save();
				}
			}
		}
	}
	public static function DemonManual() {
		$eqLogics=eqLogic::byType('CaveVin');
		foreach($eqLogics as $eqLogic){
			if($eqLogic->getConfiguration('analyse')!='manual'){
				foreach($eqLogic->getCmd() as $Commande){
					if (is_object($Commande)){
						$listener=cmd::byId($Commande->getConfiguration('SortieBoutielle'));
						if (is_object($listener)){
							$Commande->setCollectDate('');
							$Commande->event($listener->execCmd(null,2));
							$Commande->save();
						}
					}
				}
			}
		}
	}
	public static function getPinState($GPIO){
		$commands = array();
		exec("gpio mode ".$GPIO." in ",$commands,$return);
		$commands = array();
		exec("gpio read ".$GPIO,$commands,$return);
		return ($commands[0]);
	}
	public static function setPinState($GPIO,$value){
		$commands = array();
		exec("gpio mode ".$GPIO." out ",$commands,$return);
		$commands = array();
		exec("gpio write ".$GPIO.' '.$value,$commands,$return);
	}
	public function StartDemon() {
        	/*switch($this->getConfiguration('analyse')){
			case 'manual':
				$cron = cron::byClassAndFunction('CaveVin', 'DemonManual');
				if (!is_object($cron)) {
					$cron = new cron();
					$cron->setClass('CaveVin');
					$cron->setFunction('DemonManual');
					$cron->setEnable(1);
					$cron->setSchedule('* * * * *');
					$cron->setTimeout('60');
					$cron->save();
					$cron->start();
					$cron->run();
				}
			break;
			case 'local':
				$cron = cron::byClassAndFunction('CaveVin', 'DemonGPIO');
				if (!is_object($cron)) {
					$cron = new cron();
					$cron->setClass('CaveVin');
					$cron->setFunction('DemonGPIO');
					$cron->setOption(array('id' => $this->getId()));
					$cron->setEnable(1);
					$cron->setSchedule('* * * * *');
					$cron->setTimeout('60');
					$cron->save();
					$cron->start();
					$cron->run();
				}
			break;
		}*/
    }
    	public function preSave() {
		for($heightCase=1;$heightCase<=$this->getConfiguration('heightCase');$heightCase++){
			for($widthCase=1;$widthCase<=$this->getConfiguration('widthCase');$widthCase++){
				$Name=$this->getName().'_'.$widthCase."x".$heightCase;
				self::AddCommande($this,$Name);
			}
		}
    	}
  	public function toHtml($_version = 'mobile',$Dialog=true) {
	/*	if ($this->getIsEnable() != 1) {
			return '';
		}
		if (!$this->hasRight('r')) {
			return '';
		}*/
		$_version = jeedom::versionAlias($_version);
		$replace = array(
			'#id#' => $this->getId(),
			'#name#' => ($this->getIsEnable()) ? $this->getName() : '<del>' . $this->getName() . '</del>',
			'#eqLink#' => $this->getLinkToConfiguration(),
			'#background#' => $this->getBackgroundColor($_version),				
			'#height#' => $this->getDisplay('height', 'auto'),
			'#width#' => $this->getDisplay('width', '250'),
			'#dialog#' => $Dialog,
		);	
		$HtmlCasier='';
		for($heightCase=1;$heightCase<=$this->getConfiguration('heightCase');$heightCase++){
			$HtmlCasier.= '<tr>';
			for($widthCase=1;$widthCase<=$this->getConfiguration('widthCase');$widthCase++){
					$HtmlCasier.='<td>#'.$this->getName().'_'.$widthCase.'x'.$heightCase.'#</td>';
				}
			$HtmlCasier.='</tr>';
		}
		if ($this->getIsEnable()) {
			foreach ($this->getCmd(null, null, true) as $cmd) {
				 $replaceCasier['#'.$cmd->getName().'#'] = $cmd->toHtml($_version);
				 $replaceCasier['#Couleur#'] = mesVin::byId($cmd->getLogicalId())->getCouleur();
			}
		}   
		$replace['#Casier#']=template_replace($replaceCasier,$HtmlCasier) ;
		return template_replace($replace, getTemplate('core', $_version, 'eqLogic','CaveVin'));
	}
}
class CaveVinCmd extends cmd {
    public function execute($_options = array()) {
        
    }
}
?>
