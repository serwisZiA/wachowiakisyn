<?php

namespace backend\models;

use backend\models\Address;
use backend\models\Model;
use yii\helpers\ArrayHelper;
use vakorovin\yii2_macaddress_validator\MacaddressValidator;

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property integer $mac
 * @property string $desc
 * @property integer $address
 * @property integer $type
 */

class Host extends Device
{
	const TYPE = 5; //id w tabeli device_type dla Hosta
	
	public function init()
	{
		$this->type = self::TYPE;
		parent::init();
	}
	
	public static function find()
	{
		return new DeviceQuery(get_called_class(), ['type' => self::TYPE]);
	}
	
	public function beforeSave($insert)
	{
		$this->type = self::TYPE;
		return parent::beforeSave($insert);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		
        return ArrayHelper::merge(
            parent::rules(),
            [
            	['mac', 'filter', 'filter' => function($value) { return strtolower($value); }],
            	['mac', 'string', 'min'=>12, 'max'=>17, 'tooShort'=>'Za mało znaków', 'tooLong'=>'Za dużo znaków'],
            	['mac', 'required', 'message'=>'Wartość wymagana'],
            	['mac', MacaddressValidator::className(), 'message'=>'Zły format'],
            	['mac', 'unique', 'targetClass' => 'backend\models\Host', 'message' => 'Mac zajęty', 'when' => function ($model, $attribute) {
            		return strtolower($model->{$attribute}) !== strtolower($model->getOldAttribute($attribute));
            	}],
            	['mac', 'trim', 'skipOnEmpty' => true],
            	
                [['mac'], 'safe'],
            ]
        );       
	}
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_CREATE] = ArrayHelper::merge($scenarios[self::SCENARIO_CREATE], ['mac']);
		$scenarios[self::SCENARIO_UPDATE] = ArrayHelper::merge($scenarios[self::SCENARIO_UPDATE], ['mac']);
		$scenarios[self::SCENARIO_TOSTORE] = ArrayHelper::merge($scenarios[self::SCENARIO_TOSTORE], ['address', 'status']);
		$scenarios[self::SCENARIO_TOTREE] = ArrayHelper::merge($scenarios[self::SCENARIO_TOTREE], ['address', 'status']);
		//$scenarios[self::SCENARIO_DELETE] = ['close_date', 'close_user'];
			
		return $scenarios;
	}
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
    
	public function attributeLabels()
	{
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'layer3' => 'Warstwa',
                'distribution' => 'Rodzaj',
            ]
        ); 
	}
}
