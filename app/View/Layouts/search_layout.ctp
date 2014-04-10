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
<title><?php echo "LILDBI WEB"; ?></title>
<?php
echo $this->Html->script('jquery');
echo $this->Html->script('ui/jquery-ui');
echo $this->Html->script('bootstrap');
echo $this->Html->script('general');

echo $this->Html->meta('icon');

echo $this->Html->css('custom-styles');
echo $this->Html->css('bootstrap');
//echo $this->Html->css('bootstrap-responsive');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

echo $this->Js->writeBuffer(array('cache'=>TRUE));

?>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container" style="width: 86%;">
			
				<?php echo $this->Html->link('LiLDBI Web', array('plugin' => false, 'controller' => 'pages', 'action' => 'display', 'home'), array('class' => 'brand')); ?>
				<div class="nav-collapse collapse navbar-responsive-collapse">
                	<ul class="nav pull-rigth">
                    	<li><?php echo $this->Html->link(__('Registrarse'), array('plugin' => false, 'controller'=>'users', 'action'=>'login')); ?></li>
                    </ul>
				</div>
               
				<!-- /.nav-collapse -->
			</div>
		</div>
		<!-- /navbar-inner -->
	</div>
	<div id="container-fluid" class="container-general" >
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
		<div id="footer">
			<footer>
			<hr>
				<p height="5" align="center">
					<font face="Verdana" size="1">BIREME/OPS/OMS - Centro
						Latinoamericano y del Caribe de Informaci&oacute;n en Ciencias de
						la Salud</font><br> <font face="Verdana" size="1">LILDBI-Web
							Versi&oacute;n 1.8 - 2013 </font>
				
				</p>
			
			</footer>
		</div>
	</div>
</body>
</html>
