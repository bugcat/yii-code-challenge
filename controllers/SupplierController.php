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
        if ( $request->post('export') ) {
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
                ['class' => CheckboxColumn::class],
                [
                    'attribute' =>'id',
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Support for comparison operators'
                    ],
                ],
                [
                    'attribute' =>'name',
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Support fuzzy query'
                    ],
                ],
                [
                    'attribute' =>'code',
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Support fuzzy query'
                    ],
                ],
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

        // get post data
        $request = Yii::$app->request;
        $columns = $request->post('columns') ?: [];
        $isAll = $request->post('is_all');
        $rowsStr = $request->post('rows_str');
        $rows = explode(',', $rowsStr);

        // Set column headers
        $fields = ['ID'];
        if ( in_array('name', $columns) ) {
            $fields[] = 'Name';
        }
        if ( in_array('code', $columns) ) {
            $fields[] = 'Code';
        }
        if ( in_array('t_status', $columns) ) {
            $fields[] = 'T Status';
        }
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        if ( $isAll ) {
            $model = new SupplierSearch();
            $query = $model->search($request->get(), 'query');
            $suppliers = $query->all();
        } else {
            $suppliers = Supplier::findAll($rows);
        }
        foreach ( $suppliers as $supplier ) {
            $lineData = [$supplier->id];
            if ( in_array('name', $columns) ) {
                $lineData[] = $supplier->name;
            }
            if ( in_array('code', $columns) ) {
                $lineData[] = $supplier->code;
            }
            if ( in_array('t_status', $columns) ) {
                $lineData[] = $supplier->t_status;
            }
            fputcsv($f, $lineData, $delimiter);
        }

        // Move back to beginning of file
        fseek($f, 0);

        // Set headers to download file rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '";');

        //output all remaining data on a file pointer
        fpassthru($f);
        exit;
    }

}
