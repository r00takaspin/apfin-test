
<div class="hero-unit">
    <h3>Необходимо авторизоваться или зарегистрироваться</h3>
    <p>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
    <div class="pull">
        <button type="button" class="btn btn-large btn-success" onclick="location.href = '<?=Yii::app()->createUrl("auth/register")?>'">Регистрация</button> или
        <button type="button" class="btn btn-large btn-primary" onclick="location.href = '<?=Yii::app()->createUrl("auth/login")?>'">Авторизация</button>
    </div>
</div>