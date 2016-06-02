<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if(Yii::$app->user->identity->user_type == Yii::$app->params['user.userTypeOperator']) { ?>
        <p>
            <?= Html::a('Create Reports', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'exam',
            [
                'label' => 'Patient',
                'value' => function ($model) {
                    if(isset($model->patient->user)) {
                        return $model->patient->user->name;
                    } else {
                        return '-';
                    }
                },
            ],
            'referred_doctor',
            //'prescription_image',
            // 'prescrption_text:ntext',
            // 'summary:ntext',
            // 'status',
            // 'is_deleted',
            // 'created_by',
            // 'created_date',
            // 'modified_by',
            // 'modified_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return Yii::$app->user->identity->user_type == Yii::$app->params['user.userTypeOperator'] ? true : false;
                    },
                    'delete' => function ($model) {
                        return Yii::$app->user->identity->user_type == Yii::$app->params['user.userTypeOperator'] ? true : false;
                    },
                ]
            ],
        ],
    ]); ?>
</div>
