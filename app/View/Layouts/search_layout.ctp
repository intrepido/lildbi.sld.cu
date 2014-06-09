<?php
$lilDBIDescription = __d('cake_dev', 'LILDBI: Biblioteca Virtual de Salud');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
  <head>
  
	<?php echo $this->Html->charset("utf-8"); ?>   
    <title><?php echo "LILDBI WEB"; ?></title>  

	<?php
		echo $this->Html->meta('infomed.ico', $this->Html->webroot('img/infomed.ico'), array('type' => 'icon'));

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('custom-styles');
		echo $this->Html->css('bootstrap-responsive.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>		
    
  </head>  
  <body>
      <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
              <div class="container-fluid">
				  <button type="button" class="btn btn-navbar" data-toggle="collapse"
					data-target=".nav-collapse">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				  </button>              
                  <?php echo $this->Html->link('LiLDBI Web', array('controller' => 'pages', 'action' => 'display', 'home'), array('class' => 'brand')); ?>
                  <div class="nav-collapse collapse navbar-responsive-collapse">

                      <ul class="nav pull-rigth">
						  <?php if($this->Session->read('userRol') != 'Administrador' && $this->Session->read('userRol') != 'Editor' && $this->Session->read('userRol') != 'Documentalista'){ ?>
                              <li><?php echo $this->Html->link(__('Registrarse'), array('plugin' => false, 'controller'=>'users', 'action'=>'login')); ?></li>
                          <?php }else{ ?>
                              <li><?php echo $this->Html->link(__('Administrar'), array('plugin' => false, 'controller'=>'admin')); ?></li>
                          	  <li><?php echo $this->Html->link('Salir', array('plugin' => false, 'controller'=>'users', 'action'=>'logout')); ?></li>
						  <?php } ?>   
                      </ul>
                      
                      <div class="btn-group pull-right">
                      
       					 <?php 
						 	if($this->Session->check('folder')){
								$docs = $this->Session->read('folder');
								if(empty($docs)){
									echo $this->Html->link(__('Carpeta ').$this->Html->tag('icon',null,array('class'=>'icon-folder-close icon-white')), array( 'action'=>'viewFolder'),array('plugin' => false,'class' => 'btn btn-small btn-primary','escape' => false)); 
								}else{
									echo $this->Html->link(__('Carpeta ').$this->Html->tag('icon',null,array('class'=>'icon-folder-open icon-white' )), array( 'action'=>'viewFolder'),array('plugin' => false,'class' => 'btn btn-small btn-primary','escape' => false));
								}
							}else{
								echo $this->Html->link(__('Carpeta ').$this->Html->tag('icon',null,array('class'=>'icon-folder-close icon-white')), array( 'action'=>'viewFolder'),array('plugin' => false,'class' => 'btn btn-small btn-primary','escape' => false));
							}
						 ?>

                          <button class="btn  btn-primary dropdown-toggle" style="height: 26px;" data-toggle="dropdown">
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                          	 <li><a href='/searches/viewFolder'><i class="icon-folder-open"></i> Abrir Carpeta </a></li>
                             <li><a href='#' class='removeAllDoc'><i class="icon-trash"></i> Vaciar Carpeta </a></li>
                          </ul>
             		  </div>
                      
                      <?php
						if ($this->Session->check('userRol')){ 
					  ?>
						  <div class="navbar-form pull-right" style="margin-top: 10px;margin-right: 50px;">
							<div>
								<p style="color: #ffffff;">
								<?php
									if($this->Session->read('userRol') == 'Administrador') {
										echo  __('Administrador:') ;
									}
									if($this->Session->read('userRol') == 'Editor') {
										echo  __('Editor:') ;
									}
									if($this->Session->read('userRol') == 'Documentalista') {
										echo  __('Documentalista:') ;
									}
								?>
								<?php echo $current_user['username']; ?>
								</p>
							</div>
						  </div>
					  <?php } ?>  
                  </div>
                  <!-- /.nav-collapse -->
              </div>
          </div>
          <!-- /navbar-inner -->
      </div>
      <div id="wrap">
		<div class="container-fluid">
			<div class="row-fluid">
				<div id="content">
					<?php echo $this->Session->flash('auth', array(
							'element' => 'alert',
							'params' => array('plugin' => 'TwitterBootstrap'),
				)); ?>
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
		<div id="push"></div>
	 </div>
	 <div id="footer">
		<div class="container">
			<p class="muted credit" align="center"
				style="margin-bottom: 0px; margin-top: 10px;">
				BIREME/OPS/OMS - Centro Latinoamericano y del Caribe de
				Informaci&oacute;n en Ciencias de la Salud <br> LILDBI-Web
					Versi&oacute;n 1.8 - 2013 
			
			</p>
		</div>
	 </div> 
	 <script src="http://localhost:3000/socket.io/socket.io.js"></script>
	 <?php   
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('general');
		echo $this->Js->writeBuffer(array('cache'=>TRUE));
		echo $this->fetch('script');
	 ?>
  </body>  
</html>


