<?php echo $this->Media->iframe('Article', $this->request->data['Article']['id']); ?>
<?php echo $this->Form->create('Article'); ?>

<fieldset>
	<legend> <?php echo __('Edit article'); ?> </legend>
	<?php echo $this->Form->input('title'); ?>
        <?php echo $this->Form->input('subtitle'); ?>
	<?php echo $this->Form->input('intro', array('rows' => 3)); ?>
	<?php echo $this->Media->ckeditor('body', array('label' => 'Content')); ?>
	<?php echo $this->Form->input('game_id', array('label' => 'Game')); ?>
        <?= $this->Form->input('published', array(
            'options' => array(
                '1' => 'Make public',
                '0' => 'Do not make public'
            )
        )); 
		if(AuthComponent::user('role') == 'admin') :
		echo $this->Form->input('type', array(
            'options' => array(
                '0' => 'Normal',
				'1' => 'Main News',
				'2' => 'Colonne droite',
				'3' => 'Main + droite'
            )
        )); endif;?>
        <?php echo $this->Form->input('Tag'); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        
</fieldset>
<?php echo $this->Form->end(__('Save')); 



debug($thumbID);?>



