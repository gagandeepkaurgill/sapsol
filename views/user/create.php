<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Registration Form';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDxTV3a6oL6vAaRookXxpiJhynuUpSccjY&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

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

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php 
		if($model->hasErrors()){

		  echo Html::errorSummary($model,['errorOptions' => ['encode' => false,'class' => 'help-block']]);

		}
	?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
