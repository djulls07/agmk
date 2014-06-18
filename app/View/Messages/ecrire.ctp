<?php echo $this->Form->create('Message'); ?>
<?php 
	$label_dest="";
	if (isset ($user_dest) )
	{
		echo $this->Form->input('dest_id', array('type' => 'hidden', 'value'	=>	$user_dest['User']['id'], 'id' => 'dest_id'));
		echo $this->Form->input('dest_username', array('type'	=>	'hidden', 'value'	=>	''.$user_dest['User']['username'].'', 'autocomplete' => 'off', 'id' => 'MessageTo', 'label' => 'To'));
		$label_dest = " -> ".$user_dest['User']['username'];
	}
	else
	{
		echo $this->Form->input('dest_username', array('autocomplete' => 'off', 'id' => 'MessageTo', 'label' => 'To'));
		echo $this->Form->input('dest_id', array('type' => 'hidden', 'id' => 'dest_id'));
	}
		?>
<div id="results">
</div>

<?php echo $this->Form->input('content', array('type' => 'text', 'label' => 'Message '.$label_dest, 'rows' => 3)); ?>
<?php echo $this->Form->end(__('Send')); ?>

<?php echo $this->Html->script('ecrire'); ?>

<?php 
if (isset ($user_dest) )
	echo $this->Html->link('Back', array('controller'=>'users','action' => 'view', $user_dest['User']['id']));?>
	
<?php
if (isset ($user_dest) )
if ($user_dest['User']['id'] == 74 ) :
echo $this->Html->css('soundsystem');
		$scoop_number=3;
		$shadow_speed = 40;
		$cc_height=335;
		$cc_width=220;
		print "<div style=\"margin:auto; width:".$scoop_number*$cc_width."px;\">";
		
		for($j=1;$j<=$scoop_number;$j++)
		{
		print"<div style=\"width:".($cc_width*$j+5*($j-1))."px; height:".$cc_height."px; position:relative; margin-top:".(0)."px; margin-left:".($cc_width*($scoop_number-$j)/2)."px;\">";
		
		for($i=0;$i<$j;$i++)
		{
		/*if ($j==9 && $i==5)
		ajoutonclick(); onclick:changestyle();*/ //TODO
	?>
	<div class="caisse_contour" style="float:left; margin-left:<?php $i==0?print'0':print'5'; ?>px">
		<div class="caisse">
			<div class="bords">
			</div>
			<div class="rond">
				<div class="rondbis">
					<div class="rondter">
						<div class="rond2">
							<div class="rond2bis">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="caisse_bot">
				<div class="basse">
					<div class="basse1">
					</div>
					<div class="basse2">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
		if($j	!=0) print"</div>";
		}
		
		endif;
	?>