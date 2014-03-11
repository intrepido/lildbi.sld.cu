
<style type="text/css">
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #f5f5f5;
}

.form-signin {
	max-width: 400px;
	padding: 19px 29px 29px;
	padding-bottom: 0px;
	margin: 20 auto 10px;
	margin-bottom: 40px;
	background-color: #fff;
	border: 1px solid #e5e5e5;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
	-moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
	box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
}

.form-signin .form-signin-heading,.form-signin .checkbox {
	margin-bottom: 10px;
}

.form-signin input[type="text"],.form-signin input[type="password"] {
	font-size: 16px;
	height: auto;
	margin-bottom: 15px;
	padding: 7px 9px;
}
</style>

<?php
echo $this->Form->create('User', array('class' => 'form-signin'));?>
<h2 class="form-signin-heading">Por favor, identif&iacute;quese</h2>
<hr>
<?php echo $this->Form->input('username', array('label' => '', 'class' => 'input-block-level', 'placeholder' => 'Nombre de Usuario'));
echo $this->Form->input('password', array('label' => '', 'class' => 'input-block-level', 'placeholder' => 'Clave de Usuario'));?>
<hr>
<h4 class="form-signin-heading">Acceso:</h4>
<?php echo $this->Form->input('rol', array('options' => $rols, 'label' => ''));
?>
<hr>

<div class="form-actions">
	<table>
		<tr>
			<td>
				<div id="loginCancelButton">
						<?php echo $this->Form->button(__('Cancelar'), array('type' => 'button'));?>
				</div>
			</td>
			<td>
				<div id="loginConfirmButton">
						<?php echo $this->Form->end(__('Confirmar'));?>
				</div>
			</td>			
		</tr>
	</table>



</div>
<div></div>




