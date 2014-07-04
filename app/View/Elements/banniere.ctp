<?php
$specific_user_color="orange";
$specific_user_avatar="avatar.jpg";
$specific_user_notifications=10;
$specific_user_messages=0;
$specific_user_GMT=2;
?>
<div class="banniere">
	<div class="banniere_content">
		<div class="pub">
			<a href="?homebarre=new_bar1">new_bar1</a>
			<a href="?homebarre=new_bar2">new_bar2</a>
			<a href="?homebarre=new_bar3">new_bar3</a>
			<!--<img src="http://t0.gstatic.com/images?q=tbn:ANd9GcT4Aox9gE3y41VNE3SlC8sqS7_xvxODwkD9dfxk5EPRe0agB8dvbkbeGRBR">-->
		</div>
		<div class="banniere_image">
		</div>
		<div class="pub">pub
			<!--<img src="http://t0.gstatic.com/images?q=tbn:ANd9GcT4Aox9gE3y41VNE3SlC8sqS7_xvxODwkD9dfxk5EPRe0agB8dvbkbeGRBR">-->
		</div>
</div>
</div>

<?php if (isset ($_GET['homebarre'] ) ) :
?>
	 <STYLE type="text/css">
		div.home_barre /* la 1e barre : accueil, login... */
		{
			background-image	:	url('../img/<?php print $_GET['homebarre'];?>.png');
		}
	 </STYLE>
<?php endif; ?>