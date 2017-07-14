<?php

namespace backend\modules\sys\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $title
 */
class Test extends \yii\db\ActiveRecord
{


    //省市区
    public $provinces;
    public $city;
    public $area;


}
