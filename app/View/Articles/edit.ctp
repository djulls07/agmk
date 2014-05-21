<?php echo $this->Media->iframe('Article', $this->request->data['Article']['id']); ?>
<?php echo $this->Form->create('Article'); ?>

<fieldset>
	<legend> <?php echo __('Edit article'); ?> </legend>
	<?php echo $this->Form->input('title'); ?>
        <?php echo $this->Form->input('subtitle'); ?>
	<?php echo $this->Form->input('intro', array('rows' => 3)); ?>
	<?php echo $this->Media->ckeditor('body', array('label' => 'Content')); ?>
	<?php echo $this->Form->input('Game'); ?>
        <?= $this->Form->input('published', array(
            'options' => array(
                '1' => 'Make public',
                '0' => 'Do not make public'
            )
        )); ?>
        <?php echo $this->Form->input('Tag'); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        
</fieldset>
<?php echo $this->Form->end(__('Save')); ?>



