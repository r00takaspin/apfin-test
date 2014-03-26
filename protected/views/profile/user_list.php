<h1>Все пользователи</h1>

<?php
foreach($user_list as $user):
?>
    <br><br>
    <div class="container-fluid well span8">
        <div class="row-fluid">
            <div class="span2" >
                <?
                if($user->preview && $user->preview->hasImage())
                    echo CHtml::image($user->preview->getUrl('preview'),'',array('class'=>'img-rounded'));
                else
                    echo CHtml::image(Yii::app()->baseUrl.'/images/default_avatar.png','',array('class'=>'img-rounded'));
                ?>
            </div>

            <div class="span8">
                <h3><?=$user->first_name?> <?=$user->last_name?></h3>
                <h6><?=$user->login?></h6>
                <h6><?=$user->country->name?></h6>
                <h6><a href="#">Профиль</a></h6>
            </div>

            <div class="span2">
                <div class="btn-group">
                    <?php
                    echo CHtml::ajaxSubmitButton('Добавить',Yii::app()->createUrl('profile/addFriend'),
                        array(
                            'type'=>'POST',
                            'data'=> 'js:{"from": "'.$current_user->id.'", "to": "'.$user->id.'" }',
                            'success'=>'js:function(string){ alert(string); }'
                        ),array('class'=>'btn btn-success',));
                    ?>
                </div>
            </div>
        </div>
    </div>
<? endforeach; ?>

<div class="clearfix" />