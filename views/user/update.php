<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update Your Information';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyACXbkRIrXevX-JBKUaXJCSHc_LjJ-jtKg&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

<script type="text/javascript">
	function init_map() {		
		var input = document.getElementById('user-address');
		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.addListener('place_changed', function() {
			var place = autocomplete.getPlace();
		});
	}
	google.maps.event.addDomListener(window, 'load', init_map);
</script>


<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>    
	
	<?= $form->field($model, 'Address')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>
	
	<?php /* $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'email_verification')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($model, 'Notes')->textarea(['rows' => 6]) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
