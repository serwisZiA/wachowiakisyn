<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Manufacturer;
use backend\models\Model;
use yii\helpers\Url;
use backend\models\Swith;
use backend\models\Router;

/* @var $this yii\web\View */
/* @var $model backend\models\Installation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="add-store-form">

    <?php $form = ActiveForm::begin([
    	'id' => $modelDevice->formName(),
    	'validationUrl' => Url::toRoute(['router/validation', 'type' => Swith::TYPE])	
    		
    ]); ?>    
    
    <?= $form->field($modelDevice, 'manufacturer')->dropDownList(
        ArrayHelper::map(Manufacturer::find()->orderBy('name')->all(), 'id', 'name'),
        [
            'prompt' => 'Wybierz producenta', 
            'onchange' => '$(".field-router-model").removeAttr("style");'
                . '$(".field-router-serial").removeAttr("style");'
                . '$(".field-router-mac").removeAttr("style");'
                . '$(".field-router-desc").removeAttr("style");'
                . '$.get( "' . Url::toRoute('model/list') . '&typeId=" + '. Router::TYPE .' + "&manufacturerId=" + $(this).val(), function(data) {'
                    . '$("select#router-model").html(data);'   
                . '} )'            
        ]
    )?>
    
    <?= $form->field($modelDevice, 'model', ['options' => ['style' => ['display' => 'none']]])->dropDownList(
        ArrayHelper::map(Model::find()->orderBy('name')->all(), 'id', 'name'),
        [
            'prompt' => 'Wybierz model', 
        ]
    )?>
    
    <?= $form->field($modelDevice, 'serial', 
        [
            'enableAjaxValidation' => true, 
            'validateOnChange' => false,
            'options' => ['style' => ['display' => 'none']],
        ]  
    )?>
    
    <?= $form->field($modelDevice, 'mac', 
        [       
            'enableAjaxValidation' => true, 
            'validateOnChange' => false,
            'options' => ['style' => ['display' => 'none']],
        ]
    )?>
    
    <?= $form->field($modelDevice, 'desc', ['options' => ['style' => ['display' => 'none']]])->textarea()?>
    
    <div class="form-group">
        <?= Html::submitButton($modelDevice->isNewRecord ? 'Dodaj' : 'Update', ['class' => $modelDevice->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
       
    <?php ActiveForm::end(); ?>

</div>

<script>

$(function() {

	$('#<?= $modelDevice->formName(); ?>').on('beforeSubmit', function(e){
	
		var form = $(this);
	 	$.post(
	  		form.attr("action"), // serialize Yii2 form
	  		form.serialize()
	 	).done(function(result){
			
	// 		console.log(result);
	 		if(result == 1){
	 			$(form).trigger('reset');
				$('#modal-add-store').modal('hide');
	 			$.pjax.reload({container: '#store-grid-pjax'});
	 		}
	 		else{
			
	 			$('#message').html(result);
	 		}
	 	}).fail(function(){
	 		console.log('server error');
	 	});
		return false;				
	});

});

</script>