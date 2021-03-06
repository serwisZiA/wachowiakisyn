<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\models\Host;

/**
 * @var Host $modelDevice
 */
?>

<!-------------------------------------------- otwórz kalendarz okno modal -------------------------------------------->

	<?php Modal::begin([
		'id' => 'modal-change-mac',	
		'header' => '<center><h4>Zmiana MAC</h4></center>',
		'size' => 'modal-sm',
		'options' => [
			'tabindex' => false, // important for Select2 to work properly
			'enforceFocus' => false,
			'style' => ['position' => 'fixed'],
			'backdrop' => false,
			//'class' => 'modal bottom-sheet'
		],	
	]);
	
	echo "<div id='modal-content-change-mac'></div>";
	
	Modal::end(); ?>

<!--------------------------------------------------------------------------------------------------------------------->  

<?php 
echo DetailView::widget([
	'model' => $modelDevice,
	'options' => [
			'class' => 'table table-bordered detail-view',
	],
	'attributes' => [
		'id',	
		[
			'label' => 'Adres',
			'value' => $modelDevice->modelAddress->toString()
		],
		[
			'label' => 'Konfiguracja',
			'value' => $modelDevice->start_date
		],
		[
			'label' => 'Status',
			'value' => $modelDevice->status ? 'Aktywny' : 'Nieaktywny'
		],
		[
			'label' => 'Typ',
			'value' => $modelDevice->modelType->name
		],
		[
			'label' => 'Mac',
			'format' => 'raw',	
			'value' => Html::a($modelDevice->mac, Url::to("http://172.20.4.17:701/index.php?sourceid=3&filter=clientmac%3A%3D" . base_convert(preg_replace('/:/', '', $modelDevice->mac), 16, 10) . "&search=Search"), ['target'=>'_blank']) . ' ' . Html::a('Zmień', Url::toRoute(['device/change-mac', 'id' => $modelDevice->id]),['class' => 'change-mac'])
		],
	]
]);
?>

<script>

$(function(){
	$('.change-mac').on('click', function(event){
        
		$('#modal-change-mac').modal('show')
			.data('mac', '<?= $modelDevice->mac ?>')
			.find('#modal-content-change-mac')
			.load($(this).attr('href'));

		//potrzebne by okno modal nie blokowało się
		$("#device_desc").css("position", "absolute");

		
	
        return false;
	});

	//włącza spowtorem przesówanie opisu urządzenia po zmianie mac
	$('#modal-change-mac').on('hidden.bs.modal', function () {
		$("#device_desc").css("position", "fixed");
	});
});

</script>