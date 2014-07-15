<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$lilDBIDescription = __d('cake_dev', 'LILDBI: Biblioteca Virtual de Salud');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset("utf-8"); ?>
<title><?php echo "LILDBI WEB"; ?>
</title>

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
				<?php echo $this->Html->link('LiLDBI Web', array('plugin' => false, 'controller' => 'pages', 'action' => 'display', 'home'), array('class' => 'brand')); ?>
				<div class="nav-collapse collapse navbar-responsive-collapse">
					<ul class="nav">
						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"><?php echo __('Sistema') ?> <b
								class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><a href="#"><?php echo __('Disponibilidad') ?> </a></li>
								<li><a href="#"><?php echo __('Aviso a los Usuarios') ?> </a>
								</li>
							</ul>
						</li>
						<li><?php echo $this->Html->link('Usuarios', array('plugin' => false, 'controller'=>'users', 'action'=>'index')); ?>
						</li>
						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"><?php echo __('Base de Datos') ?>
								<b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li class="dropdown-submenu"><a tabindex="-1" href="#"><?php echo __('Definiciones') ?>
								</a>
									<ul class="dropdown-menu">
										<li><a href="#"><?php echo __('Definiciones Generales') ?> </a>
										</li>
										<li><a href="#"><?php echo __('Tipos de Registros') ?> </a>
										</li>
										<li><a href="#"><?php echo __('Complementos') ?> </a></li>
										<li><a href="#"><?php echo __('Campos') ?> </a></li>
										<li><a href="#"><?php echo __('FST') ?> </a></li>
										<li><a href="#"><?php echo __('Mensajes') ?> </a></li>
									</ul>
								</li>
								<li><a href="#"><?php echo __('Generar Invertido') ?> </a></li>
								<li><?php echo $this->Html->link('Importar Codificadores', array('plugin' => false, 'controller'=>'Codifiers', 'action'=>'generate')); ?>
									<li><?php echo $this->Html->link('Importar Bases', array('plugin' => false, 'controller'=>'bases', 'action'=>'index')); ?>
								</li>
									<li><a href="#"><?php echo __('Desbloquear') ?> </a></li>
									<li><a href="#"><?php echo __('Reiniciar Base') ?> </a></li>
							
							</ul>
						</li>
						<li><?php echo $this->Html->link('Informe', array('plugin' => false, 'controller'=>'admin', 'action'=>'reports')); ?>
						</li>
						<li id="change-profile" class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"> <?php echo __('Cambiar Perfil') ?>
								<b class="caret"></b>
						</a>
							<ul id="profiles" class="dropdown-menu">
							</ul>
						</li>
						<li><?php echo $this->Html->link('Salir', array('plugin' => false, 'controller'=>'users', 'action'=>'logout')); ?>
						</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li class="divider-vertical"></li>
					</ul>

					<div class="navbar-form pull-right" style="margin-top: 10px;">
						<div>
							<p style="color: #ffffff;">
								<?php echo  __('Administrador:') ?>
								<?php echo $current_user['username']; ?>
							</p>
						</div>

					</div>
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
	<?php  
	 $connectionNode = Configure::read('Node'); //Datos de la conexion de nodejs
	?>
	<script type="text/javascript">
		//<![CDATA[ //Se declaran los datos de conexion de nodejs de forma global en la variable 'window.nodeConnection' de esta forma desde cualquier JS se puede establecer la conexion
	           window.nodeConnection = JSON.parse('<?php echo json_encode(array('host' => $connectionNode['host'], 'port' => $connectionNode['port'])); ?>');	
	    //]]>
	</script>
	<script src="http://<?php echo $connectionNode['host']; ?>:<?php echo $connectionNode['port']; ?>/socket.io/socket.io.js"></script>
	<?php  
	echo $this->Html->script('jquery');
	echo $this->Html->script('bootstrap.min');
	echo $this->Html->script('general');
	echo $this->Js->writeBuffer(array('cache'=>TRUE));
	echo $this->fetch('script');
	?>
</body>
</html>
