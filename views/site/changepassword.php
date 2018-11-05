<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Ganti Password';
?>
<div class="row">
    <div class="col-md-12">
       <div class="box box-primary">
        <div class="box-header with-border">
        
            <?php $form = ActiveForm::begin([
                'id'=>'changepassword-form',
                'options'=>['class'=>'form-horizontal'],
                'fieldConfig'=>[
                    'template'=>"{label}\n<div class=\"col-lg-3\">
                                {input}</div>\n<div class=\"col-lg-5\">
                                {error}</div>",
                    'labelOptions'=>['class'=>'col-lg-2 control-label'],
                ],
            ]); ?>
                    <?= $form->field($model,'oldpass',['inputOptions'=>[
                        'placeholder'=>'Old Password'
                    ]])->passwordInput() ?>
       
                    <?= $form->field($model,'newpass',['inputOptions'=>[
                        'placeholder'=>'New Password'
                    ]])->passwordInput() ?>

                    <?= $form->field($model,'repeatnewpass',['inputOptions'=>[
                        'placeholder'=>'Repeat New Password'
                    ]])->passwordInput() ?>
       
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-11">
                <?= Html::submitButton('Change password',[
                    'class'=>'btn btn-primary'
                ]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
        
        </div>
       </div>
    </div>
</div>