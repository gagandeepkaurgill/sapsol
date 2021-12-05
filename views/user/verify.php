<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sapsol';

?>
<div class="user-view">

    <div class="jumbotron">
	
	<?php   
			if(Yii::$app->session->hasFlash('error'))
				echo Yii::$app->session->getFlash('error'); 
			elseif(Yii::$app->session->hasFlash('warning'))
				echo Yii::$app->session->getFlash('warning'); 
			else { 
				if($model){ ?>
				<h2>Congratulations! <?= $model->name ?></h2>

				<p class="lead">You have successfully verified your account. You can login now.</p>

				<p>
					<?php echo Html::a('Login', Url::toRoute('/site/login'), ['class'=>'btn btn-lg btn-primary']); ?>
				</p>
				
				<?php }
			}
	 ?>
	
    </div>

</div>
