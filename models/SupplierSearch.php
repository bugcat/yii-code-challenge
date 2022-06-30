<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier
{

    // allow id operators
    const ID_PATTERN = '/^(\>|\<|=|\>=|\<=|\!=)?(\d+)$/';

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            //[['id'], 'integer'],
            ['id', 'match', 'pattern' => self::ID_PATTERN],
            [['name', 'code'], 'safe'],
            ['t_status', 'in', 'range' => ['ok', 'hold']],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $return = 'provider')
    {
        $query = Supplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // load the search form data and validate
        if ( !($this->load($params) && $this->validate()) ) {
            return 'provider' == $return ? $dataProvider : $query;
        }

        // adjust the query by adding the filters
        preg_match(self::ID_PATTERN, $this->id, $matches);
        if ( $matches ) {
            $operator = $matches[1] ?? null;
            $id = $matches[2] ?? 0;
            if ( $operator ) {
                $query->andFilterWhere([$operator, 'id', $id]);
            } else {
                $query->andFilterWhere(['id' => $id]);
            }
        }
        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['t_status' => $this->t_status]);

        return 'provider' == $return ? $dataProvider : $query;
    }

}
