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
    <div class="span8">
        <blockquote>
            <? if ($user->country->required_third_name): ?>
                <p><strong><?=$user->last_name?> <?=$user->first_name?> <?=$user->third_name?></strong></p>
            <? else: ?>
                <p><strong><?=$user->first_name?> <?=$user->last_name?></strong></p>
            <? endif?>

            <small><cite title="Source Title"><?=$user->country->name?>  <i class="icon-map-marker"></i></cite></small>
            <p><strong>Счета:</strong></p>
            <? if ($user->bills): ?>
                <table class="table-bordered" style="width: 40%">
                    <tr>
                        <td><strong>Валюта</strong></td>
                        <td><strong>Значение</strong></td>
                    </tr>
                <?foreach($user->bills as $bill):?>
                    <tr>
                        <td><?=$bill->currency->currency?></td>
                        <td><?=$bill->amount?></td>
                    </tr>
                <?endforeach;?>
                </table>
            <? endif;?>
            <p>
            </p>
        </blockquote>
    </div>
</div>
<BR />

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
