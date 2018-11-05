<?php
namespace app\models;

use app\models\Usermanagemenet;
use yii\base\Model;
use Yii;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserMan
 *
 * @author Kurokage
 */
class Usermanagemenet extends Model {
   
    public $username;
    public $password;
    public $email;
    public $level;
    
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique','targetClass' => 'app\models\User', 'message' => 'Username ini tidak bisa digunakan'],
            ['username', 'string', 'min' => 6, 'max' => 255],
            
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Email ini telah digunakan'],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['level', 'safe'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'username' => 'User Name',
            'password' => 'Password',
            'email' => 'Email',
            'level' => 'Level'
        ];
    }
    
    public function inputan(){
        if ($this->validate()) {
            $user = new User(); //membuat object baru untuk inputan user
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = 10;
//            $user->level = $this->level;
            $user->level = $this->level;
            if ($user->save()) {
                return $user;
            }
            
        }
    }
}