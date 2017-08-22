<?php
namespace backend\widgets\provinces;

use yii;
use yii\base\Widget;

/**
 * Class Provinces
 * @package backend\widgets\left
 */
class Provinces extends Widget
{
    /**
     * 省
     * @var
     */
    public $provincesName;

    /**
     * 市
     * @var
     */
    public $cityName;

    /**
     * 区
     * @var
     */
    public $areaName;

    /**
     * 模型
     * @var array
     */
    public $model;

    /**
     * 表单
     * @var
     */
    public $form;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        !$this->provincesName && $this->provincesName = 'provinces';
        !$this->cityName && $this->cityName = 'city';
        !$this->areaName && $this->areaName = 'area';
    }

    public function run()
    {
        return $this->render('index', [
            'form' => $this->form,
            'model' => $this->model,
            'provincesName' => $this->provincesName,
            'cityName' => $this->cityName,
            'areaName' => $this->areaName,
        ]);
    }
}
?>