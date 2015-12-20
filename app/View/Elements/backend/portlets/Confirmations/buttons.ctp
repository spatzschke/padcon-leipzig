<div class="buttons">
	<?php
	$id_addCustomer = 'addCustomer';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_addCustomer,
		"icon" => "user",
		"text" => "Kunde hinzufügen"));
	echo $this->element('backend/helper/modalHelper', array(
		"id" => $id_addCustomer,
		"url" => "\/admin\/Customers\/indexAjax\/ajax\/".$cartId,
		"redirect" => $redirectURL));	
	
		
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
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
	
	$id_addProduct = 'addProduct';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_addProduct,
		"icon" => "th-large",
		"text" => "Produkt hinzufügen"));	
	echo $this->element('backend/helper/modalHelper', array(
		"id" => $id_addProduct,
		"url" => "\/admin\/Products\/indexAjax\/ajax\/".$cartId,
		"redirect" => $redirectURL));
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	$id_settings = 'settings_btn';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_settings,
		"icon" => "cog",
		"text" => "Einstellung"));		

	echo $this->element('backend/helper/modalHelper', array(
		"id" => $id_settings,
		"url" => "\/admin\/".ucfirst($this->request->params['controller'])."\/settings\/".$dataId,
		"redirect" => $redirectURL));
	 
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	$id_createConfirmation = 'createConfirmation';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_createConfirmation,
		"icon" => "file",
		"href" => $this->Html->link('Lieferschein erstellen', '/admin/'.$nextSheet.'/convert/'.$dataId, array('escape' => false, 'class' => 'btn btn-default'))));		
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	$id_createPartDelivery = 'createPartDelivery';
	echo $this->element('backend/helper/sheetButtonHelper', array(
		"id" => $id_createPartDelivery,
		"icon" => "file",
		"text" => "Teil-Lieferung erstellen"));		

	echo $this->element('backend/helper/modalHelper', array(
		"id" => $id_createPartDelivery,
		"url" => "\/admin\/".$nextSheet."\/convertPart\/".$dataId,
		"redirect" => ""));	
	
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

	$('#<?php echo $id_addAdditionalAddress;?>_btn a').addClass('disabled');
	$('#<?php echo $id_addProduct;?>_btn a').addClass('disabled');	
	$('#<?php echo $id_createConfirmation;?>_btn a').addClass('disabled');
	$('#<?php echo $id_settings;?>_btn a').addClass('disabled');
	$('#<?php echo $id_print;?>_btn a').addClass('disabled');
	
	<?php if(!empty($this->data['Address']['street'])) { ?>
		$('#<?php echo $id_addProduct;?>_btn a').removeClass('disabled');
		$('#<?php echo $id_settings;?>_btn a').removeClass('disabled');
		
		$('#<?php echo $id_addCustomer;?>_btn .input-group-addon').css('backgroundColor','lightgreen');	
		
		<?php if($this->data['Address']['count'] > 1) {?>			
			$('#<?php echo $id_addAdditionalAddress;?>_btn a').removeClass('disabled');	
		<?php } ?>			
	<?php } ?>
	
	<?php if(!empty($this->data['CartProduct'])) { ?>	
		$('#<?php echo $id_addProduct;?>_btn .input-group-addon').css('backgroundColor','lightgreen');	
	<?php } ?>
	// <?php if(!empty($this->data[$controller]['additional_text'])) { ?>	
		// $('#<?php echo $id_settings;?>_btn .input-group-addon').css('backgroundColor','lightgreen');
	// <?php } ?>
	<?php 
	if(((!empty($this->data[$controller]['additional_text'])) && (!empty($this->data['CartProduct']))) || $this->request->params['action'] == 'admin_view') { ?>	
		$('#<?php echo $id_createConfirmation;?>_btn a').removeClass('disabled');
		$('#<?php echo $id_print;?>_btn a').removeClass('disabled');
	<?php } ?>
	
</script>