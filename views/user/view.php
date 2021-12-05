<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Information', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'name',
            'email',
            'email_verification',
			['attribute'=>'created_at',
				'label' => 'Account Created on',
				'value' => function ($model) {
					return Yii::$app->formatter->asDateTime($model->created_at, 'php:m/d/Y');
				},
			],
			['attribute'=>'updated_at',
				'label' => 'last updated',
				'value' => function ($model) {
					return Yii::$app->formatter->asDateTime($model->updated_at, 'php:m/d/Y');
				},
			],
            'Address',
            'Notes',
        ],
    ]) ?>

</div>
