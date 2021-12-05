<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $auth_key
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property string $email_verification
 * @property int $created_at
 * @property int $updated_at
 * @property string $Address
 * @property string $Notes
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
	
	const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
	
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
            TimestampBehavior::className(),
        ];
    }
	
	/*public function beforeSave($insert) {
		if ($this->isNewRecord)
			$this->created_at = new CDbExpression('NOW()');
		else
			$this->updated_at = new CDbExpression('NOW()');
			
		return parent::beforeSave();
	}*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'auth_key', 'email', 'password_hash', 'created_at', 'updated_at', 'Address'], 'required'],
            [['status'], 'integer'],
            [['email_verification', 'Notes'], 'string'],
            [['username', 'name', 'email', 'password_hash', 'created_at', 'updated_at'], 'string', 'max' => 200],
            [['auth_key'], 'string', 'max' => 32],
            [['password_reset_token', 'Address'], 'string', 'max' => 500],
			[['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],	
		
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'email_verification' => 'Email Verification',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'Address' => 'Address',
            'Notes' => 'Notes',
        ];
    }
	
	/* send verification Email */
	public function verificationEmail($user_id)
    {
		$user = User::findIdentity($user_id);  
		
		$message = "";
		$message .= "<b>Congratulations</b>, You are now a member of Sapsol Technologies.<br> 
						Before you continue with your membership benefits, you need to verify your account. Please click on following given link and then verify your account.<br><br>
						<a target='_blank' href='".Url::base()."/index.php/user/verification?user=".$user_id."'>CLICK ME</a>";
		
        return \Yii::$app->mailer->compose()
			->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['senderName']])
			->setTo($user->email)
			->setReplyTo([Yii::$app->params['adminEmail'] => Yii::$app->params['senderName']])
			->setSubject('Sapsol Technologies Verification')
			->setHtmlBody($message)
			->send();
    }
	
	
	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
	
	/**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
 
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
	
	/**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
 
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
 
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
	
	
	
	
}
