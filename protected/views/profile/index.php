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
            <p>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.
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
