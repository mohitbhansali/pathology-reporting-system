<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = $model->exam;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="report">

        <div class="row header">

            <div class="col-sm-4">
                <div class="well">
                    <p>Name: <strong><?= isset($model->patient->user)?$model->patient->user->name:"-"; ?></strong></p>
                    <p>Gender: </p>
                    <p>Age</p>
                    <p>Email: lukasz@bootstrapmaster.com</p>
                    <p>Phone: +48 123 456 789</p>
                </div>
            </div><!--/col-->

            <div class="col-sm-4">
                <div class="well">
                    <p>Referred Doctor: <strong><?= $model->referred_doctor;?></strong></p>
                    <p>Konopnickiej 42</p>
                    <p>43-190 Mikolow, Poland</p>
                    <p>Email: lukasz@bootstrapmaster.com</p>
                    <p>Phone: +48 123 456 789</p>
                </div>
            </div><!--/col-->

            <div class="col-sm-4">
                <div class="well">
                    <p>Invoice <strong>#90-98792</strong></p>
                    <p>March 30, 2013</p>
                    <p>VAT: PL9877281777</p>
                    <p>Account Name: BootstrapMaster.com</p>
                    <p><strong>SWIFT code: 99 8888 7777 6666 5555</strong></p>
                </div>
            </div><!--/col-->

        </div><!--/row-->
        <?php if($dataProvider->getTotalCount() > 0): ?>
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th class="center">#</th>
                <th>Test Name</th>
                <th>Result</th>
                <th class="center">Reference Interval</th>
            </tr>
            </thead>
            <tbody>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '',
                'itemView' => '_details',
                'emptyText' => '',
            ])?>
            </tbody>
        </table>
        <?php endif; ?>
        <div class="row">

            <div class="col-lg-4 col-sm-5 notice">
                <div class="well">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </div>
            </div><!--/col-->

            <div class="col-lg-4 col-lg-offset-4 col-sm-5 col-sm-offset-2 recap">
                <?php if($dataProvider->getTotalCount() > 0) { ?>
                    <a href="#" class="btn btn-info"><i class="fa fa-print"></i> Download Report</a>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addMore"><i class="fa fa-usd"></i> Add More Test</a>
                <?php } else { ?>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addMore"><i class="fa fa-usd"></i> Add Test in Report</a>
                <?php } ?>
            </div><!--/col-->

        </div><!--/row-->

    </div>

    <!-- Modal -->
    <div id="addMore" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Tests</h4>
                </div>
                <div class="modal-body">
                    <div class="patient-tests-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($patientTests, 'patient_report_fk_id')->hiddenInput(['value' => $model->id])->label(false) ?>

                        <?php $dropDownTest = ArrayHelper::map($testTypes,'id','name'); ?>
                        <?= $form->field($patientTests, 'tests_type_fk_id')->dropDownList($dropDownTest,['prompt'=>'Select Test']); ?>

                        <?= $form->field($patientTests, 'test_result')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton($patientTests->isNewRecord ? 'Create' : 'Update', ['class' => $patientTests->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
