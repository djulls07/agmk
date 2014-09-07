<?php $this->start('menu_forum_gauche'); ?>
<li class="col-md-12 text-center"><a href="http://agamek.org/forums/view/<?php echo $forum['Forum']['id'];?>">Back</a></li>
<?php $this->end(); ?>
<div class="col-md-12">
	<?php echo $this->Form->create('Topic');?>
	<fieldset>
		<legend>New topic</legend>
		<label>Subject</label><?php echo $this->Form->input('subject', array('type'=>'text', 'label'=>false));?>
		<label>Message</label><?php echo $this->Form->input('message', array('type'=>'textarea', 'id'=>'PostMessage', 'label'=>false));?>
	</fieldset>
	<button class="btn" type="submit">Submit</button>
	</form>
</div>