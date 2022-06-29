<?php
namespace app\models;

use yii\db\ActiveRecord;

class Supplier extends ActiveRecord
{

    public static function tableName()
    {
        return '{{supplier}}';
    }

}
