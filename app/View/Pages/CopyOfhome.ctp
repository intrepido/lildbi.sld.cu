
<center>

	<table border="0" width="600" cellspacing="0" cellpadding="0"
		align="center" bgcolor="#779DC1">
		<tr>
			<td width="52"><?php echo $this->Html->link(
					$this->Html->image('help.gif', array('alt' => "Ayuda", 'border' => '0')), 'http://bireme.br/',
					array('target' => '_blank', 'escape' => false)); ?></td>
			<td width="274" align="center">&nbsp;</td>
			<td width="274" align="right"><a href="/lildbi/index_pt.htm">Portugu&ecirc;s</a>&nbsp;&nbsp;<a
				href="/lildbi/index_en.htm">English</a>
			</td>
		</tr>
	</table>
</center>


<table width="600" cellspacing="5" cellpadding="0" border="0"
	align="center">
	<tr>
		<td width="10%" height="50" align="right"><?php echo 	$this->Html->image('pointer.gif'); ?>
		</td>
		<td><?php echo $this->Html->link('Administracion de la base de datos', array('controller' => 'admin', 'action' => 'index'), array('class' => 'menu')); ?>

		</td>
	</tr>
	<tr>
		<td width="10%" height="50" align="right"><?php echo 	$this->Html->image('pointer.gif'); ?>
		</td>
		<td><?php echo $this->Html->link('Busqueda', array('controller' => 'searches', 'action' => 'index'), array('class' => 'menu')); ?>

		</td>
	</tr>
	<tr>
		<td height="70">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#779DC1" height="20" align="right" colspan="2"><?php echo $this->Html->link("Metodolog&iacute;a LILACS - Manuales", 'http://bvsmodelo.bvsalud.org/php/level.php?lang=es&component=27&item=3',
				array('target' => '_blank', 'escape' => false)); ?>&nbsp;&nbsp;&nbsp;

		</td>
	</tr>
</table>

