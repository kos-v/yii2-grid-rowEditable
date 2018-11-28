<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Form;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
interface ValidatableFormInterface
{
    /**
     * @param int $index
     * @param int|string $key
     * @param string $attribute
     * @param string $message
     * @return void
     */
    public function addEditableRowsError($index, $key, $attribute, $message);

    /**
     * @param int|null $index
     * @param int|null|string| $key
     * @param null|string $attribute
     * @return void
     */
    public function clearEditableRowsErrors($index = null, $key = null, $attribute = null);

    /**
     * @param int|null $index
     * @param int|null|string| $key
     * @param null|string $attribute
     * @return array
     */
    public function getEditableRowsErrors($index = null, $key = null, $attribute = null);

    /**
     * @param int|null $index
     * @param int|null|string| $key
     * @param null|string $attribute
     * @return string
     */
    public function getEditableRowsFirstError($index = null, $key = null, $attribute = null);

    /**
     * @param int|null $index
     * @param int|null|string| $key
     * @param null|string $attribute
     * @return bool
     */
    public function hasEditableRowsErrors($index = null, $key = null, $attribute = null);

    /**
     * @return bool
     */
    public function validateEditableRows();
}