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
echo $this->Html->script('jquery');
echo $this->Html->script('bootstrap');



echo $this->Html->meta('icon');

echo $this->Html->css('bootstrap');
echo $this->Html->css('index');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>

	<div id="container" class="container">
		<div id="header">

			<center>
				<table border="0" cellpadding="0" cellspacing="0" width="600"
					height="95>	
			      	<tr>
					
					<a name="top">
						<td width="10%" valign="top"><?php echo $this->Html->link($this->Html->image('bvs.gif', array('alt' => $lilDBIDescription, 'border' => '0')), 'http://bireme.br/',
								array('target' => '_blank', 'escape' => false)); ?></td>
						<td width="90%" valign="top"><?php echo $this->Html->link($this->Html->image('head.gif', array('alt' => $lilDBIDescription, 'border' => '0')), 'http://modelo.bvsalud.org/',
								array('target' => '_blank', 'escape' => false)); ?>
					</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
				
				</table>

			</center>
		</div>
		<div id="content">


			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth', array(
					'element' => 'alert',
					'params' => array('plugin' => 'TwitterBootstrap'),
	)); ?>


			<?php echo $this->fetch('content'); ?>


		</div>
		<div id="footer">
			<table width="600" cellspacing="0" cellpadding="0" border="0"
				align="center" height="200">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td height="5" align="center"><font face="Verdana" size="1">BIREME/OPS/OMS
							- Centro Latinoamericano y del Caribe de Información en Ciencias
							de la Salud</font><br> <font face="Verdana" size="1">LILDBI-Web
								Versión 1.8 - 2013 </font>
					
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
