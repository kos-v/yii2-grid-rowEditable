<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Input;

use yii\base\BaseObject;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class InputDto extends BaseObject
{
    /**
     * @var string
     */
    public $attribute;

    /**
     * @var \yii\base\Model
     */
    public $form;

    /**
     * @var string
     */
    public $formAttribute;

    /**
     * @var int
     */
    public $index;

    /**
     * @var int|string
     */
    public $key;

    /**
     * @var \yii\base\Model
     */
    public $model;
}