<?php

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Pathology Lab Reporting System';
?>
<div class="site-index">

    <section class="block">

        <?php if(Yii::$app->user->isGuest): ?>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => ['login'],
                'fieldConfig' => [
                    'template' => "{input}",
                    'options' => [
                        'tag'=>'span'
                    ]
                ]
            ]); ?>
            <?php echo $form->errorSummary($model); ?>
                <div class="search">
                    <div class="search-icon"></div>
                    <?= AutoComplete::widget([
                        'attribute' => "patient",
                        'id' => "patient",
                        'clientOptions' => [
                            'source' => $users,
                            'autoFill' => true,
                            'minLength' => '1',
                            'select' => new JsExpression("function(event, ui) {
                                console.log(ui.item.id);
                                    $('#loginform-email').val(ui.item.email);
                                }")
                        ],
                        'options' => [
                            'placeholder' => 'Enter Patient Name..',
                            'class' => 'form-control',
                        ],
                    ]);
                    ?>
                    <?= $form->field($model, 'email')->hiddenInput()->label(false) ?>
                    <div class="location-icon"></div>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter Pass Code', 'class' => 'form-control location'])->label(false) ?>
                    <input value="SEARCH" class="search-button btn btn-primary" type="submit">
                </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </section>
</div>
