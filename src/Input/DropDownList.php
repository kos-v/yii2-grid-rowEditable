<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Input;

use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class DropDownList extends AbstractInput
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var string|array|null
     */
    public $selected = null;

    /**
     * @var string|array|null
     */
    public function getSelected()
    {
        return $this->selected !== null
            ? $this->selected
            : $this->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return Html::dropDownList(
            $this->getName(),
            $this->getSelected(),
            $this->items,
            $this->options
        );
    }
}