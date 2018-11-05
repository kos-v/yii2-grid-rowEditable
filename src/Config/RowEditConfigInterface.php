<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Config;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
interface RowEditConfigInterface
{
    const INPUT_TYPE_INPUT = \Kosv\Yii2Grid\RowEditor\Input\Input::class;
    const INPUT_TYPE_TEXTAREA = \Kosv\Yii2Grid\RowEditor\Input\Textarea::class;
    const INPUT_TYPE_DROPDOWNLIST = \Kosv\Yii2Grid\RowEditor\Input\DropDownList::class;

    /**
     * @param array $config
     * @return $this
     */
    public function merge($config);
}