<?php

namespace frontend\controllers;

use common\models\TestsType;
use Yii;
use common\models\Reports;
use common\models\ReportsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\PatientTests;
use common\models\PatientTestsSearch;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PatientTestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Add New Test
        $patientTests = new PatientTests();
        if ($patientTests->load(Yii::$app->request->post()) && $patientTests->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        // Get users for autocomplete
        $testTypes = TestsType::find()
            ->select([ 'CONCAT(name, " : " , reference_interval) as name', 'id as id'])
            ->where(['status'=>1,'is_deleted'=>0])
            ->asArray()
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'patientTests' => $patientTests,
            'testTypes' => $testTypes
        ]);
    }

    /**
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();
        // Get users for autocomplete
        $users = User::find()
            ->select(['user.name as value', 'patient_details.id as name' , 'patient_details.id as id'])
            ->joinWith('patient')
            ->where(['user.status'=>1,'user.is_deleted'=>0])
            ->andWhere(['user.user_type' => 3])
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'users' => $users
            ]);
        }
    }

    /**
     * Updates an existing Reports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * Download Report as PDF
     */
    public function actionDownloadReport($id)
    {
        $report = Reports::findOne($id);

        $file_folder = 'uploads/order-invoice/';
        $fileNameWithoutExt = 'pathologylabs_report_'.$model->id.time();
        $filename = $fileNameWithoutExt.'.pdf';
        $file_path = $file_folder.$filename;

        $orderInvoice = new OrderInvoice();
        $orderInvoice->order_fk_id = $model->id;
        // Check if proforma or real invoice
        if(isset($_POST['proforma_invoice'])) {
            $orderInvoice->is_proforma = '1';
        } else {
            $orderInvoice->is_proforma = '0';
        }
        $orderInvoice->filename = $filename;
        $orderInvoice->created_by = Yii::$app->user->identity->id;
        $orderInvoice->save();

        $mPDF1=new mPDF();
        $mPDF1->setAutoTopMargin = 'stretch';
        //$mPDF1->setAutoBottomMargin = 'pad';
        $mPDF1->SetHeader($this->renderPartial('_order_invoice_header', array(
            'invoiceType' => $orderInvoice->is_proforma,
            'invoicename' => 'BOD'.$orderInvoice->order_fk_id,
            'order'=> $model,
        )));
        $mPDF1->SetFooter('{PAGENO}');
        $mPDF1->WriteHTML($this->renderPartial('_order_invoice', array(
            'order'=> $model,
            'orderProduct' => $orderProduct,
            'invoicename' => 'BOD'.$orderInvoice->order_fk_id,
            'invoiceType' => $orderInvoice->is_proforma
        ), true));

        //saving the file on file server
        $mPDF1->Output($file_path, 'F');
    }

    /**
     * Deletes an existing Reports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
