<?php 
	if(empty($this->params['pass'])) {
		$this->requestAction('Site_Contents/loadCMSContent/'.$position.'/'.$this->params['controller'].'/'.$this->params['action'].'/'); 
	} else {
		$this->requestAction('Site_Contents/loadCMSContent/'.$position.'/'.$this->params['controller'].'/'.$this->params['action'].'/'.$this->params['pass'][0]); 
	}
	
	
?>