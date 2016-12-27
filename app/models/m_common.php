<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class m_common extends Model
{

    public $id;
    //分类ID
    public $type_id;
    //父分类ID
    public $type_pid;
    //项目名
    public $item_id;
    //登录时间
    public $insert_time;
    //登录用户
    public $insert_user_id;
    //更新时间
    public $update_time;
    //更新用户
    public $update_user;
    //网站ID
    public $site_id;

    public function getSource()
    {
        return 'm_common';
    }

    /**
     * Before create the user assign a password
     */
//    public function beforeValidationOnCreate()
//    {
//        if (empty($this->password)) {
//
//            // Generate a plain temporary password
//            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));
//
//            // The user must change its password in first login
//            $this->mustChangePassword = 'Y';
//
//            // Use this password as default
//            $this->password = $this->getDI()
//                ->getSecurity()
//                ->hash($tempPassword);
//        } else {
//            // The user must not change its password in first login
//            $this->mustChangePassword = 'N';
//        }
//
//        // The account must be confirmed via e-mail
//        $this->active = 'N';
//
//        // The account is not suspended by default
//        $this->suspended = 'N';
//
//        // The account is not banned by default
//        $this->banned = 'N';
//    }
//
//    /**
//     * Send a confirmation e-mail to the user if the account is not active
//     */
//    public function afterSave()
//    {
//        if ($this->active == 'N') {
//
//            $emailConfirmation = new EmailConfirmations();
//
//            $emailConfirmation->usersId = $this->id;
//
//            if ($emailConfirmation->save()) {
//                $this->getDI()
//                    ->getFlash()
//                    ->notice('A confirmation mail has been sent to ' . $this->email);
//            }
//        }
//    }
//
//    /**
//     * Validate that emails are unique across users
//     */
//    public function validation()
//    {
//        $this->validate(new Uniqueness(array(
//            "field" => "email",
//            "message" => "The email is already registered"
//        )));
//
//        return $this->validationHasFailed() != true;
//    }

    public function initialize()
    {
//        $this->belongsTo('profilesId', 'Vokuro\Models\Profiles', 'id', array(
//            'alias' => 'profile',
//            'reusable' => true
//        ));
//
//        $this->hasMany('id', 'Vokuro\Models\SuccessLogins', 'usersId', array(
//            'alias' => 'successLogins',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
//
//        $this->hasMany('id', 'Vokuro\Models\PasswordChanges', 'usersId', array(
//            'alias' => 'passwordChanges',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
//
//        $this->hasMany('id', 'Vokuro\Models\ResetPasswords', 'usersId', array(
//            'alias' => 'resetPasswords',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
    }
}
