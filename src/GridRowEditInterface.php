<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable;

use Kosv\Yii2Grid\RowEditable\Config\RowEditConfigInterface;

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