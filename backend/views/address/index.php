<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use backend\models\Address;
use kartik\select2\Select2;
use yii\base\Widget;

/**
 * @var $this yii\web\View
 * @var $searchModel backend\models\AddressSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Adresy';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            	'class' => 'yii\grid\SerialColumn',
            ],
        	'id', //TODO kolumna powinna być dostępna tylko dla administratora	
            [
            	'attribute' => 'ulica_prefix',
            	'options' => ['style'=>'width:5%'],
            	'filter' => Html::activeDropDownList(
            		$searchModel, 
            		'ulica_prefix', 
            		ArrayHelper::map(
            			Address::find()->select('ulica_prefix')->groupBy('ulica_prefix')->all(), 
            			'ulica_prefix', 
            			'ulica_prefix'
            		), 
            		['prompt'=>'', 'class'=>'form-control']
            	),	
    		],
        	[
        		'attribute'=>'ulica',
        		'filter'=> Select2::widget([
        			'model' => $searchModel,
        			'attribute' => 'ulica',
        			'data' => ArrayHelper::map(Address::find()->select('ulica')->groupBy('ulica')->all(), 'ulica', 'ulica'),
        			'options' => ['placeholder' => 'Ulica'],
        			'pluginOptions' => [
        				'allowClear' => true	//dodaje możliwość czyszczenia poprzez `x`
        			],
        		]),
        		'options' => ['style'=>'width:20%;']
        	],
            'dom',
        	'dom_szczegol',	
            'lokal',
        	'pietro',        		
            'lokal_szczegol',
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view} {update}',
        	]
        ]
    ]); ?>

</div>
