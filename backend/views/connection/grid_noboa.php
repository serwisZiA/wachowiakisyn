<?php 
use app\models\Package;
use backend\models\Address;
use backend\models\Type;
use kartik\grid\GridView;
use nterms\pagesize\PageSize;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var backend\models\ConnectionSearch $modelSearch
 */

$this->params['breadcrumbs'][] = 'Niezaksięgowane';
?>

<?= GridView::widget([
	'id' => 'connection-grid',
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'filterSelector' => 'select[name="per-page"]',
	'pjax' => true,
	'pjaxSettings' => [
		'options' => [
				'id' => 'connection-grid-pjax'
		]
	],
	'resizableColumns' => FALSE,
	'summary' => 'Widoczne {count} z {totalCount}',
	'export' => false,
	'panel' => [
			'before' => $this->renderAjax('_search', [
					'searchModel' => $searchModel,
			]),
	],
	'rowOptions' => function($model){
		if ($model->pay_date <> null && $model->close_date == null) {
	
			return ['class' => 'pay'];
		}
		elseif ($model->close_date <> null) {
	
			return ['class' => 'inactiv'];
		}
	},
	'columns' => [
        [
			'header'=>'Lp.',
			'class'=>'yii\grid\SerialColumn',
           	'options'=>['style'=>'width: 4%;'],
		],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index, $column){

                return GridView::ROW_COLLAPSED;
            },
            'detail' => function($data){

                return 'Info: '.$data->info.'<br>Info Boa: '.$data->info_boa;
            },
        ],          
        [
        	'attribute' => 'start_date',
        	'value'=> 'start_date',
        	'filterType' => GridView::FILTER_DATE,
        	'filterWidgetOptions' => [
        		'model' => $searchModel,
        		'attribute' => 'start_date',
        		'pickerButton' => false,
        		'language' => 'pl',
        		'pluginOptions' => [
        			'format' => 'yyyy-mm-dd',
        			'todayHighlight' => true,
        			'endDate' => '0d',
        		]
        	],
        	'options' => ['id'=>'start', 'style'=>'width:10%;'],
        ],
        [	
            'attribute'=>'street',
            'value'=>'modelAddress.ulica',
            'filter'=> Html::activeDropDownList($searchModel, 'street', ArrayHelper::map(Address::find()->select('ulica')->groupBy('ulica')->orderBy('ulica')->all(), 'ulica', 'ulica'), ['prompt'=>'', 'class'=>'form-control']),
            'options' => ['style'=>'width:12%;'],
        ],	
        [
            'attribute'=>'house',
            'value'=>'modelAddress.dom',
            'options' => ['style'=>'width:5%;'],
        ],
        [
            'attribute'=>'house_detail',
            'value'=>'modelAddress.dom_szczegol',
            'options' => ['style'=>'width:5%;'],
        ],
        [
            'attribute'=>'flat',
            'value'=>'modelAddress.lokal',
            'options' => ['style'=>'width:5%;'],
        ],
        [
            'attribute'=>'type',
            'value'=>'modelType.name',
            'filter'=> Html::activeDropDownList($searchModel, 'type', ArrayHelper::map(Type::find()->all(), 'id', 'name'), ['prompt'=>'', 'class'=>'form-control']),
            'options' => ['style'=>'width:5%;'],
        ],
        [
	        'attribute'=>'package',
	        'value'=>'modelPackage.name',
	        'filter'=> Html::activeDropDownList($searchModel, 'package', ArrayHelper::map(Package::find()->all(), 'id', 'name'), ['prompt'=>'', 'class'=>'form-control']),
	        'options' => ['style'=>'width:5%;'],
        ],
        [
	        'class'=>'kartik\grid\BooleanColumn',
	        'header'=>'Umowa',
	        'attribute'=>'nocontract',
	        'trueLabel' => 'Nie',
	        'falseLabel' => 'Tak',
	        'trueIcon' => GridView::ICON_INACTIVE,
	        'falseIcon' => GridView::ICON_ACTIVE,
	        'options' => ['style'=>'width:5%;'],
        ],
        [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute' => 'socket',
            'header' => 'Gniazdo',
            'options' => ['style'=>'width:7%;'],
        ],                       
        [
        	'attribute' => 'conf_date',
        	'value'=> 'conf_date',
        	'filterType' => GridView::FILTER_DATE,
        	'filterWidgetOptions' => [
        		'model' => $searchModel,
        		'attribute' => 'conf_date',
        		'pickerButton' => false,
        		'language' => 'pl',
        		'pluginOptions' => [
        			'format' => 'yyyy-mm-dd',
        			'todayHighlight' => true,
        			'endDate' => '0d',
        		]
        	],
        	'options' => ['id'=>'start', 'style'=>'width:10%;'],
        ],
        [
        	'attribute' => 'pay_date',
        	'value'=> 'pay_date',
        	'filterType' => GridView::FILTER_DATE,
        	'filterWidgetOptions' => [
        		'model' => $searchModel,
        		'attribute' => 'pay_date',
        		'pickerButton' => false,
        		'language' => 'pl',
        		'pluginOptions' => [
        			'format' => 'yyyy-mm-dd',
        			'todayHighlight' => true,
        			'endDate' => '0d',
        		]
        	],
        	'options' => ['id'=>'start', 'style'=>'width:10%;'],
        ],
        [
        	'attribute' => 'close_date',
        	'value'=> 'close_date',
        	'filterType' => GridView::FILTER_DATE,
        	'filterWidgetOptions' => [
        		'model' => $searchModel,
        		'attribute' => 'close_date',
        		'pickerButton' => false,
        		'language' => 'pl',
        		'pluginOptions' => [
        			'format' => 'yyyy-mm-dd',
        			'todayHighlight' => true,
        			'endDate' => '0d',
        		]
        	],
        	'options' => ['id'=>'start', 'style'=>'width:10%;'],
        ],
        [   
            'header' => PageSize::widget([
                'defaultPageSize' => 100,
                'pageSizeParam' => 'per-page',
                'sizes' => [
                    10 => 10,
                    100 => 100,
                    500 => 500,
                    1000 => 1000,
                    //5000 => 5000,
                ],
                'template' => '{list}',
            ]),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {sync}',
        	'buttons' => [
        		'sync' => function ($model, $data) {

        			$url = Url::toRoute(['connection/sync', 'id' => $data->id]);
        			return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
        				'title' => \Yii::t('yii', 'Synchronizacja'),
        				'data-pjax' => '0',
        			]);
        		}
        	]
        ],            
    ]
]); 

$js = <<<JS
$(function(){
	$('body').on('click', 'a[title="Synchronizacja"]', function(event){
        $.get($(this).attr('href'), function(data) {
        	$.pjax.reload({container: '#connection-grid-pjax'});
		});
       
       	return false;
	});
});
JS;

$this->registerJs($js);
?>