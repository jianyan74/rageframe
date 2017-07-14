<?php

namespace api\modules\v1\controllers;

use api\controllers\AController;
/**
 * Default controller for the `v1` module
 */
class DefaultController extends AController
{
    public $modelClass = 'backend\models\ActionLog';
}
