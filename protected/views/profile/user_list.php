<?
$this->breadcrumbs=array(
    'Profile',
);
?>
<div class="span8">
    <h1>Все пользователи:</h1>
</div>

<?php
foreach($user_list as $user):
?>
    <br><br>
    <div class="container-fluid well span8">
        <div class="row-fluid">
            <div class="span2" >
                <a href="<?=Yii::app()->createUrl('profile/show',array('id'=>$user->id))?>">
                <?
                if($user->preview && $user->preview->hasImage())
                    echo CHtml::image($user->preview->getUrl('preview'),'',array('class'=>'img-rounded'));
                else
                    echo CHtml::image(Yii::app()->baseUrl.'/images/default_avatar.png','',array('class'=>'img-rounded'));
                ?>
                </a>
            </div>

            <div class="span8">
                <h3><a href="<?=Yii::app()->createUrl('profile/show',array('id'=>$user->id))?>"><?=$user->first_name?> <?=$user->last_name?></a></h3>
                <h6><?=$user->login?></h6>
                <h6><?=$user->country->name?></h6>
            </div>

            <div class="span2">
                <div class="btn-group">
                    <?php
                    if (User::isFriend($current_user->id,$user->id))
                    {
                        echo CHtml::ajaxSubmitButton('Удалить',Yii::app()->createUrl('profile/removeFriend'),
                            array(
                                'type'=>'POST',
                                'data'=> 'js:{"from": "'.$current_user->id.'", "to": "'.$user->id.'" }',
                                'success'=>'js:function(string){ location.reload(true); }',
                                'error'=>'js:function(string) {  alert(123213); }'
                            ),array('class'=>'btn btn-danger',));
                    }
                    else
                    {
                        echo CHtml::ajaxSubmitButton('Добавить',Yii::app()->createUrl('profile/addFriend'),
                            array(
                                'type'=>'POST',
                                'data'=> 'js:{"from": "'.$current_user->id.'", "to": "'.$user->id.'" }',
                                'success'=>'js:function(string){ location.reload(true); }'
                            ),array('class'=>'btn btn-success',));
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<? endforeach; ?>

<div class="clearfix" />