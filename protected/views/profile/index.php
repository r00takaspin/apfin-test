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

<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th class="span2"></th>
        <th class="span2"></th>
        <th class="span9"></th>
        <th class="span2"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><strong>John Doe</strong></td>
        <td><span class="label pull-right">Notifications</span></td>
        <td><strong>Message body goes here</strong></td>
        <td><strong>11:23 PM</strong></td>
    </tr>
    <tr>
        <td>John Doe</td>
        <td><span class="label pull-right">Notifications</span></td>
        <td>Message body goes here</td>
        <td>Sept4</td>
    </tr>
    <tr>
        <td><strong>John Doe</strong></td>
        <td><span class="label pull-right">Notifications</span></td>
        <td><strong>Message body goes here</strong></td>
        <td><strong>Sept3</strong></td>
    </tr>
    <tr>
        <td><strong>John Doe</strong></td>
        <td><span class="label pull-right">Notifications</span></td>
        <td><strong>Message body goes here</strong></td>
        <td><strong>Sept3</strong></td>
    </tr>
    </tbody>
</table>

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
