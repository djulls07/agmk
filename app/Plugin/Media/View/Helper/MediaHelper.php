<?php
class MediaHelper extends AppHelper{

	public $helpers = array('Html','Form');
	public $javascript = false;
	public $explorer = false;

	public function tinymce($field, $options = array()){
		$this->Html->script('/media/js/tinymce/tiny_mce.js',array('inline'=>false));
		return $this->textarea($field, 'tinymce', $options);
	}

	public function ckeditor($field, $options = array()) {
		$model = $this->Form->_models; $model = key($model);
		$this->Html->script('/media/js/ckeditor/ckeditor.js',array('inline'=>false));
		return $this->textarea($field, 'ckeditor', $options);
	}

	public function redactor($field, $options = array()) {
		$model = $this->Form->_models; $model = key($model);
		$this->Html->script('/media/js/redactor/redactor.min.js',array('inline'=>false));
		$this->Html->css('/Media/js/redactor/redactor.css', null, array('inline'=>false));
		return $this->textarea($field, 'redactor', $options);
	}

	public function textarea($field, $editor = false, $options = array()){
		$options = array_merge(array('label'=>false,'style'=>'width:100%;height:500px','row' => 160, 'type' => 'textarea', 'class' => "wysiwyg $editor"), $options);
		$html = $this->Form->input($field, $options);
		$models = $this->Form->_models;
		$model = key($models);
        if(isset($this->request->data[$model]['id']) && !$this->explorer){
			$html .= '<input type="hidden" id="explorer" value="' . $this->Html->url('/media/medias/index/'.$model.'/'.$this->request->data[$model]['id']) . '">';
			$this->explorer = true;
    	}
    	return $html;
	}

	public function iframe($ref,$ref_id){
		return '<iframe src="' . $this->Html->url("/media/medias/index/$ref/$ref_id") . '" style="width:100%;" id="medias-' . $ref . '-' . $ref_id . '"></iframe>';
	}
	
	public function image($imageSrc, $width, $height) {
		$imageSrc = '.'.$imageSrc;
		$info = new SplFileInfo($imageSrc);
		
		$extension = $info->getExtension();
		$baseNameAbs = substr($imageSrc, 2, -(strlen($extension)+1));
		$fileDest = $baseNameAbs . '_' . $width . 'x' . $height . '.' .$extension;
		//debug($fileDest);
		if (file_exists($fileDest)) {
			return '<img src="'.$fileDest.'"/>';
		}
		$dest = imagecreatetruecolor($width, $height);
		if ($extension == 'png') {
			$src = imagecreatefrompng($imageSrc);
		} else {
			$src = imagecreatefromjpeg($imageSrc);
		}
		list($wSrc, $hSrc) = getimagesize($imageSrc);
		/*$r = $hSrc/$wSrc;
		$width = $height/$r;*/
		imagecopyresized($dest, $src, 0,0,0,0, $width, $height, $wSrc, $hSrc);
		imagejpeg($dest, $fileDest);
		return '<img src="'.$fileDest.'"/>';
	}
}