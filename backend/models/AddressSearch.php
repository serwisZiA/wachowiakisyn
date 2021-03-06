<?php

namespace backend\models;

use backend\models\Address;
use yii\data\ActiveDataProvider;

/**
 * AddressSearch represents the model behind the search form about `app\models\Address`.
 */
class AddressSearch extends Address
{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \backend\models\Address::rules()
	 */
    public function rules() : array {
    	
        return [
            [['ulica_prefix', 'ulica', 'dom', 'dom_szczegol', 'lokal', 'lokal_szczegol'], 'safe'],
        ];
    }

    /**
     * 
     * @param array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        $query = Address::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination' => ['pageSize' => 100],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $dataProvider->setSort([
       		'attributes' => [
        		'ulica',
        		'dom',
        		'dom_szczegol',
        		'lokal',
        		'lokal_szczegol',
        		'pietro'
        			]	
        ]);
        
        $query->andFilterWhere([
            'ulica_prefix' => $this->ulica_prefix,
        	'ulica' => $this->ulica,	
            'dom' => $this->dom,
            'lokal' => $this->lokal,
        ]);

        $query->andFilterWhere(['like', 'dom_szczegol', $this->dom_szczegol])
            ->andFilterWhere(['like', 'lokal_szczegol', $this->lokal_szczegol]);

        return $dataProvider;
    }
}
