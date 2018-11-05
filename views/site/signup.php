<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    
        <?= $form->field($model, 'username',['template'=>"{input}\n{error}"])
        ->textInput(['autofocus' => true,'placeholder'=>'Username']) ?>

    <?= $form->field($model, 'email',['template'=>"{input}\n{error}"])
        ->textInput(['placeholder'=>'Email']) ?>

    <?= $form->field($model, 'password',['template'=>"{input}\n{error}"])
        ->passwordInput(['placeholder'=>'Password']) ?>

    <div>
      <?= Html::submitButton('Signup', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
     
    </div>

    <?php ActiveForm::end(); ?>

    <div class="social-auth-links text-center">
  
    </div>

    <a href="<?= yii\helpers\Url::toRoute('site/login')?>" class="text-center">Saya Sudah Memiliki Akun</a>
  </div>
  <!-- /.form-box -->
</div>

