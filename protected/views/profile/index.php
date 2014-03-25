<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
	'Profile',
);
?>
<h1><?=$user->first_name?> <?=$user->last_name?></h1>

<?
if($user->preview->hasImage())
    echo CHtml::image($user->preview->getUrl('preview'),'Medium image version');
else
    echo 'no image uploaded';
?>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
