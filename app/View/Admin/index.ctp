<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<?php
echo $this->Html->script('dashboard', TRUE);
?>

<div class="container-document">
	<h3>Dash Board</h3>
	<hr>
	<div class="row-fluid">

		<!--ADMIN-->
		<?php if($rol == 'Administrador'){?>
		<div class="span5">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Mantenimiento'); ?>
				</legend>



				<ul class="nav nav-list">
					<li class="active"><dl class="dl-horizontal">
							<dt>Desactivar Sistema:</dt>
							<dd>
								<div class="onoffswitch">
									<input type="checkbox" name="onoffswitch"
										class="onoffswitch-checkbox" id="myonoffswitch"
										<?php echo Configure::read('CFG.Maintenance') ? "" : "checked"; ?>>
									<label class="onoffswitch-label" for="myonoffswitch">
										<div class="onoffswitch-inner"></div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
							</dd>
						</dl></li>
					<li><?php echo $this->Html->link('Parametros de configuracion', array('plugin' => 'configuration', 'controller'=>'configurations', 'action'=>'index')); ?>
					</li>

				</ul>

				<!--/.well -->





			</div>
		</div>

		<div class="span5">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Usuarios en Linea'); ?>
				</legend>

				<div style='display: none' id="list-user-online" class="media"></div>

			</div>
		</div>
		<?php }?>
		
		
		<!--DOCUMENTALIST-->
		<?php if($rol == 'Documentalista'){?>
		<div class="span5">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Usuarios en Linea'); ?>
				</legend>

				<div style='display: none' id="list-user-online" class="media"></div>

			</div>
		</div>
		<?php }?>

	</div>
</div>

