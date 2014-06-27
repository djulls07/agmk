<?php
	$i = 0;
	$saisons = $event['Saison'];
?>
<div id="onglets">
	<ul>
		<?php for($i=1;$i<=count($saisons); $i++) : ?>
		<li><a href="#onglet-<?=$i;?>">Saison - <?=$i;?></a></li>
		<?php endfor; ?>
	</ul>
	<?php for($i=1; $i<=count($saisons); $i++) : ?>
	<div id="onglet-<?=$i;?>">
	Saison <?=$i;?>
	</div>
	<?php endfor; ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	$("#onglets").tabs();
})
</script>