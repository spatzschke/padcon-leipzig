<div class="users form">

<div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                     <div class="panel-heading">
                        <div class="panel-title">Nutzer hinzufügen</div>
                        
                    </div>

                    <div style="padding-top:30px" class="panel-body" >

                       <?php echo $this->Session->flash(); ?>
                            
                   
                        <?php echo $this->Form->create('User', array(
							'class' => 'form-horizontal'
						)); ?>      
							<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <?php echo $this->Form->input('name', array(
											'label' => false,
											'class' => 'form-control',
											'placeholder' => 'Name'
										));?>                                      
                                    </div>
                                      
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <?php echo $this->Form->input('username', array(
											'label' => false,
											'class' => 'form-control',
											'placeholder' => 'Benutzername'
										));?>                                      
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                       <?php echo $this->Form->input('password', array(
											'label' => false,
											'class' => 'form-control',
											'placeholder' => 'Passwort'
										));?>   
                                    </div>
                                    
                              <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                       <?php echo $this->Form->input('role', array(
								            'options' => array('admin' => 'Admin', 'author' => 'Author'),
								            'label' => false,
											'class' => 'form-control'
								        ));  ?>
                                    </div>

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                    	<input type="submit" value="Login" class="btn btn-success form-control">
                                    </div>
                                </div>
 
                     </form>



                        </div>                     
                    </div>  
        </div>
        
       
    </div>
    </div>