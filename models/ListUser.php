<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models;

use Yii;
/**
 * ini class model untuk tabel "user"
 *
 * @author Kurokage
 * 
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $level
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class ListUser extends \yii\db\ActiveRecord {
    
    public static function tableName() {
        return 'user';
    }
    
    public function rules() {
        [
            [['id','level','status','created_at','update_at'],'integer'],
            [['username','password_hash','email'],'string']
        ];        
    }
    
    public function attributeLabels() {
        return [
            'id' => 'Id User',
            'username' => 'User Name',
            'password_hash' => 'Password',
            'email' => 'Email'
        ];
    }
}
