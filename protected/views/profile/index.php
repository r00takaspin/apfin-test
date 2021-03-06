<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
	'Ваш профиль',
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
                <p><strong><?=CHtml::encode($user->last_name)?> <?=CHtml::encode($user->first_name)?> <?=CHtml::encode($user->third_name)?></strong></p>
            <? else: ?>
                <p><strong><?=CHtml::encode($user->first_name)?> <?=CHtml::encode($user->last_name)?></strong></p>
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
