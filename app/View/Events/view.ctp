<?php
	$date_debut = new DateTime($event['Event']['date_debut']);
	$date_debut = $date_debut->getTimeStamp();
	$nbTeams = count($event['Team']);
	$time = time();
	if ($event['Event']['min_teams'] > $nbTeams || $time < $date_debut) {
		if ($event['Event']['min_teams'] > $nbTeams) 
			echo '<h3>Not enough teams to start</h3>';
		if ($time < $date_debut)
			echo '<h3>Event not started</h3>';
		echo '<dl>';
		echo '<dt>Number of teams needed</dt> <dd>' .$event['Event']['min_teams'].'</dd>';
		echo '<dt>Number of teams subscribed</dt><dd> ' . $nbTeams.'</dd>';
		if ($time < $date_debut) {
			$dateTo = $date_debut-$time;
			echo '<dt>Time to event</dt><dd> ' . $dateTo.'</dd>';
		}
		else
			echo '<dt>Time to event</dt> <dd>0</dd>';
		echo '</dl>';
	} else {
		$i = 0;
		$saisons = $event['Saison'];
		?>
		<div id="onglets">
			<ul>
				<?php for($i=1;$i<=count($saisons); $i++) : ?>
					<li><a href="#onglet-<?=$i;?>">Saison <?=$i;?></a></li>
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
	<?php } ?>