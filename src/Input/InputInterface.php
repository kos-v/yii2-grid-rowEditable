<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Input;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
interface InputInterface
{
    /**
     * @param InputDto $inputDto
     * @param array $params
     */
    public function __construct(InputDto $inputDto, $params = []);

    /**
     * @return string
     */
    public function __toString();
}