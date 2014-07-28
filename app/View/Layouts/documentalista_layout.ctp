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
				<?php echo $this->Html->link('LiLDBI Web', array('controller' => 'pages', 'action' => 'display', 'home'), array('class' => 'brand')); ?>
				<div class="nav-collapse collapse navbar-responsive-collapse">
					<ul class="nav">
						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"><?php echo __('Documentos'); ?>
								<b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><?php echo $this->Html->link(__('Listar'), array('plugin' => false, 'controller'=>'documents', 'action'=>'index')); ?>
								</li>
								<li class="dropdown-submenu"><a tabindex="-1" href="#"><?php echo __('Nuevo'); ?>
								</a>
									<ul class="dropdown-menu">
										<li><?php echo $this->Html->link(__('Sin Indización'), array('plugin' => false, 'controller'=>'documents', 'action'=>'add', 'sin_indizacion')); ?>
										</li>
										<li><?php echo $this->Html->link(__('Con Indización'), array('plugin' => false, 'controller'=>'documents', 'action'=>'add', 'con_indizacion')); ?>
										</li>
									</ul>
								</li>
								<li class="divider"></li>
								<li><?php echo $this->Html->link(__('Listar Analíticas'), array('plugin' => false, 'controller'=>'analitics', 'action'=>'index')); ?>
								</li>
								<li class="divider"></li>
								<li><a href="#"><?php echo __('Indexar'); ?> </a></li>
								<li><a href="#"><?php echo __('Certificar'); ?> </a></li>
							</ul>
						</li>

						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"><?php echo __('Utilitarios'); ?>
								<b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><a href="#"><?php echo __('Importar'); ?> </a></li>
								<li><a href="#"><?php echo __('Exportar'); ?> </a></li>
								<li><a href="#"><?php echo __('Reorganizar'); ?> </a></li>
								<li><a href="#"><?php echo __('Reinvertir'); ?> </a></li>
								<li><a href="#"><?php echo __('Desbloquear'); ?> </a></li>
								<li><a href="#"><?php echo __('Reiniciar Base'); ?> </a></li>
							</ul>
						</li>
						<li><a href="#"><?php echo __('Configuración') ?> </a>
						</li>

						<li id="change-profile" class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"> <?php echo __('Cambiar Perfil') ?>
								<b class="caret"></b>
						</a>
							<ul id="profiles" class="dropdown-menu">
							</ul>
						</li>

						<li><?php echo $this->Html->link(__('Salir'), array('controller'=>'users', 'action'=>'logout')); ?>
						</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li class="divider-vertical"></li>
						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="#"><?php echo $this->Session->check('Config.language') ? $this->Html->image('flags/'. $this->Session->read('Config.language').'.png') : $this->Html->image('flags/'. Configure::read('Config.language').'.png'); ?>
								<b class="caret"></b> </a>
							<ul id='idioms' class="dropdown-menu">							
								<li><?php echo $this->Html->link($this->Html->image('flags/eng.png') . ' ' . __('Ingles'),'#',  array('id' => 'eng','escape' => false));?></li>
								<li><?php echo $this->Html->link($this->Html->image('flags/esp.png') . ' ' . __('Español'),'#',  array('id' => 'esp','escape' => false));?></li>	
								<li><?php echo $this->Html->link($this->Html->image('flags/ptr.png') . ' ' . __('Portugues'),'#',  array('id' => 'ptr','escape' => false));?></li>									
							</ul>
						</li>
					</ul>
					<div class="navbar-form pull-right" style="margin-top: 10px;">
						<div class="span20">
							<p style="color: #ffffff;">
								<?php echo __('Documentalista:') ?>
								<?php echo $current_user['username']; ?>
							</p>
						</div>

					</div>
					</ul>
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
