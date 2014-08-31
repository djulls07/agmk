<script type="text/javascript">
	function changeRank(rank)
	{
		var element = document.getElementById("teamtry");
		element.className = "myteam myteam_"+rank;
	}
</script>


<nav>
	<?php echo $this->Html->link('Create NEW TEAM', array('action' => 'add')); ?> |
	<ul style="list-style:none">
		<li><a onclick='changeRank("bronze")'>Bronze</a></li>
		<li><a onclick='changeRank("gold")'>Gold</a></li>
		<li><a onclick='changeRank("silver")'>Silver</a></li>
		<li><a onclick='changeRank("platine")'>Platine</a></li>
		<li><a onclick='changeRank("master")'>Master</a></li>
		<li><a onclick='changeRank("grandmaster")'>GrandMaster</a></li>
	</ul>
</nav>

<br />
<div id="myteams">
	<?php foreach($teams as $team) : ?>
		<div class="myteam myteam_gold" id="teamtry">
			<div class="myteam_indoor">
				<div class="myteam_left">
					<div class="myteam_left_logo">
						<img src="/img/agamek_logo_crop.png" />
					</div>
					<div class="myteam_left_tokens">
						<span>AGAMEK TOKENS</span>
						<br>
						1765
						</br>
						<img src="/img/agamek_tokens.png" />
					</div>
				</div>
				<div class="myteam_center">
					<div class="myteam_center_name">
						<?php 
							echo $this->Html->link($team['Team']['name'], array(
							'controller' => 'teams', 
							'action' => 'view', 
							$team['Team']['id']));
						?>
						<span>RANK 4</span>
					</div>
					<div class="myteam_center_banniere">
						<img src="/img/logo_agamek.png" />
					</div>
				</div>
				<div class="myteam_rigth">
					<ul class="myteam_rightul">
						<li><a href="">Lien 1</a></li>
						<li><a href="">Lien 1</a></li>
						<li><a href="">Lien 1</a></li>
						<li><a href="">Lien 1</a></li>
					</ul>
				</div>
			</div>
			<div class="myteam_success">
				<div class="myteam_success_borderbottom_left"></div>
				<div class="myteam_success_borderbottom_right"></div>
				<img src="/img/RANKS_user_team/rank_gold2.png" id="image_rank" />
			</div>
		</div>
	<?php endforeach; ?>
</div>