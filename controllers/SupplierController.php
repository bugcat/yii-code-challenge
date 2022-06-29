<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\data\ActiveDataProvider;
use app\models\{Supplier, SupplierSearch};

class SupplierController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        // run actionExport when get export request
        if ( $request->get('export') ) {
            $this->actionExport();
            Yii::$app->end();
        }
        // show grid
        $model = new SupplierSearch();
        $dataProvider = $model->search($request->get());
        $grid = GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns' => [
                [
                    'class' => CheckboxColumn::class,
                ],
                'id',
                'name',
                'code',
                [
                    // use dropdown filter
                    'attribute' =>'t_status',
                    'filter'    => ['ok' => 'OK', 'hold' => 'Hold'],
                    // To change 'All' instead of the blank option
                    'filterInputOptions' => [
                        'class'  => 'form-control',
                        'id'     => null,
                        'prompt' => 'All'
                    ],
                ],
            ],
            'filterSelector' => '.report-filter',
        ]);
        return $this->render('index', ['grid' => $grid]);
    }

    /**
     * Export CSV.
     *
     * @return void
     */
    public function actionExport()
    {
        $delimiter = ',';
        $fileName  = 'Supplier.csv';

        // Create a file pointer
        $f = fopen('php://memory', 'w');

        // Set column headers
        $fields = ['ID', 'Name', 'Code', 'T Status'];
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        $query = Supplier::find();
        // TODO
        $suppliers = $query
            ->all();
        foreach ( $suppliers as $supplier ) {
            $lineData = [
                $supplier->id,
                $supplier->name,
                $supplier->code,
                $supplier->t_status,
            ];
            fputcsv($f, $lineData, $delimiter);
        }

        // Move back to beginning of file
        fseek($f, 0);

        // Set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '";');

        //output all remaining data on a file pointer
        fpassthru($f);
        exit;
    }

}
