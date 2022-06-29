<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier
{

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['id'], 'integer'],
            [['name', 'code'], 'safe'],
            ['t_status', 'in', 'range' => ['ok', 'hold']],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Supplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['t_status' => $this->t_status]);

        return $dataProvider;
    }

}
