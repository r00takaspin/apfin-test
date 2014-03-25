<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
	'Profile',
);
?>

<div class="row">
    <div class="span2">
        <?
        if($user->preview && $user->preview->hasImage())
            echo CHtml::image($user->preview->getUrl('preview'),'',array('class'=>'img-rounded'));
        else
            echo 'no image uploaded';
        ?>
    </div>
    <div class="span4">
        <blockquote>
            <? if ($user->country->required_third_name): ?>
                <p><strong><?=$user->last_name?> <?=$user->first_name?> <?=$user->third_name?></strong></p>
            <? else: ?>
                <p><strong><?=$user->first_name?> <?=$user->last_name?></strong></p>
            <? endif?>

            <small><cite title="Source Title"><?=$user->country->name?>  <i class="icon-map-marker"></i></cite></small>
        </blockquote>
    </div>
</div>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
