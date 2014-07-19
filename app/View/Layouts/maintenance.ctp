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
<title><?php echo $title_for_layout; ?></title>

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

					<div class="navbar-form pull-right" style="margin-top: 10px;">
						<div class="span20">
							<p style="color: #ffffff;">
								<?php echo  __($this->Session->read('userRol') . ":") ?>
								<?php echo $current_user['username']; ?>
							</p>
						</div>

					</div>

					<ul class="nav pull-right">						
						<li><?php echo $this->Html->link('Salir', array('controller'=>'users', 'action'=>'logout')); ?>
						</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li class="divider-vertical"></li>
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
	echo $this->Html->script('jquery');
	echo $this->Html->script('bootstrap');
	echo $this->Html->script('login');
	echo $this->Html->script('general');
	echo $this->fetch('script');
	?>
</body>
</html>
