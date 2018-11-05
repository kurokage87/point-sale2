<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="user-search">
    <?php $form = ActiveForm::begin([
        'action' => ['daftar-user'],
        'method' => 'get',
        'layout' => 'inline'
    ])?>
    
    <?= $form->field($model, 'username')->textInput()?>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
    </div>
    
    <?php ActiveForm::end()?>
</div>
<br />
