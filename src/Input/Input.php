<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Input;

use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class Input extends AbstractInput
{
    /**
     * @var string
     */
    public $htmlInputType = 'text';

    /**
     * @var string
     */
    public $value;

    /**
     * @return string
     */
    public function __toString()
    {
        return Html::input(
            $this->htmlInputType,
            $this->getName(),
            $this->getValue(),
            $this->options
        );
    }
}