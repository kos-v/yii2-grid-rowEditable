<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Config;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
interface EditConfigInterface
{
    const INPUT_TYPE_INPUT = \Kosv\Yii2Grid\RowEditable\Input\Input::class;
    const INPUT_TYPE_TEXTAREA = \Kosv\Yii2Grid\RowEditable\Input\Textarea::class;
    const INPUT_TYPE_DROPDOWNLIST = \Kosv\Yii2Grid\RowEditable\Input\DropDownList::class;

    const SELECT_MODE_CHECKBOX = 0x1;
    const SELECT_MODE_CLICK = 0x2; //TODO: In the future version

    /**
     * @param array $config
     * @return $this
     */
    public function merge($config);
}