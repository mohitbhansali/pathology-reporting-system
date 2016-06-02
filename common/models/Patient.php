<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "patient_details".
 *
 * @property integer $id
 * @property integer $user_fk_id
 * @property string $pass_code
 * @property string $gender
 * @property integer $dob
 * @property string $height
 * @property double $weight
 * @property string $blood_group
 * @property string $address
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property User $userFk
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_fk_id', 'pass_code', 'gender', 'dob'], 'required'],
            [['user_fk_id', 'created_by', 'modified_by'], 'integer'],
            [['weight'], 'number'],
            [['address'], 'string'],
            [['created_date', 'modified_date', 'dob'], 'safe'],
            [['pass_code'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 1],
            [['height'], 'string', 'max' => 100],
            [['blood_group'], 'string', 'max' => 10],
            [['pass_code'], 'unique'],
            [['user_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_fk_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'modified_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return before save rules for model attributes.
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_by = isset(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:Yii::$app->params['user.userTypeSystem'];
        } else {
            $this->modified_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_fk_id' => 'User',
            'pass_code' => 'Pass Code',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'height' => 'Height',
            'weight' => 'Weight',
            'blood_group' => 'Blood Group',
            'address' => 'Address',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_fk_id']);
    }
}