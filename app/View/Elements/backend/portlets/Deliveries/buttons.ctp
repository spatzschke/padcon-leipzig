<div class="buttons">
	<?php
	
	$id_addAdditionalAddress = 'addAdditionalAddress';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_addAdditionalAddress,
		"icon" => "road",
		"text" => "Weitere Adressen"));		
	echo $this->element('backend/helper/modalHelper', array(
		"backdrop" => "false",
		"id" => $id_addAdditionalAddress,
		"url" => "\/admin\/Addresses\/index\/ajax\/".$dataId."\/".ucfirst($this->request->params['controller'])."\/".$addressType,
		"redirect" => $redirectURL));
			
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	/*$id_settings = 'settings_btn';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_settings,
		"icon" => "cog",
		"text" => "Einstellung"));		

	echo $this->element('backend/helper/modalHelper', array(
		"id" => $id_settings,
		"url" => "\/admin\/".ucfirst($this->request->params['controller'])."\/settings\/".$dataId,
		"redirect" => $redirectURL));
	 */
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	$id_createConfirmation = 'createBilling';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_createConfirmation,
		"icon" => "euro", 
		"href" => $this->Html->link('Rechnung erstellen', '/admin/'.$nextSheet.'/convert/'.$dataId, array('escape' => false, 'class' => 'btn btn-default'))));		
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	$id_print = 'print';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_print,
		"icon" => "print",
		"href" => $this->Html->link('Drucken', '/admin/'.ucfirst($this->request->params['controller']).'/createPdf/'.$dataId, array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank'))
		));
			
	?>	
</div>

<script>

	
	
</script>