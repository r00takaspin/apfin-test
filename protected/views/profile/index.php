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
            echo CHtml::image(Yii::app()->baseUrl.'/images/default_avatar.png','',array('class'=>'img-rounded'));
        ?>
    </div>
    <div class="span6">
        <blockquote>
            <? if ($user->country->required_third_name): ?>
                <p><strong><?=$user->last_name?> <?=$user->first_name?> <?=$user->third_name?></strong></p>
            <? else: ?>
                <p><strong><?=$user->first_name?> <?=$user->last_name?></strong></p>
            <? endif?>

            <small><cite title="Source Title"><?=$user->country->name?>  <i class="icon-map-marker"></i></cite></small>
            <BR />
            <?=$this->renderPartial("particals/_user_bills",array('user'=>$user))?>
        </blockquote>
    </div>
</div>
<BR />

<?=$this->renderPartial('particals/_news',array('friends_news'=>$friends_news));?>

<? if ($user->friends):?>
    <h3>Друзья</h3>

<div class="row">
    <?foreach($user->friends as $friend):?>
       <?=$this->renderPartial("particals/_friend",array("friend"=>$friend));?>
    <? endforeach; ?>
</div>

<? else: ?>
        <center>
            пока нет друзей <br/>
            <?=CHtml::image(Yii::app()->baseUrl.'/images/no_friends.png','',array('class'=>'img-rounded','width'=>100)); ?>
        </center>
<? endif; ?>
