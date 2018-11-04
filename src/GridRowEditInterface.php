<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor;

use Kosv\Yii2Grid\RowEditor\Config\RowEditConfigInterface;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
interface GridRowEditInterface
{
    /**
     * @return RowEditConfigInterface
     */
    public function getRowEditConfig();
}