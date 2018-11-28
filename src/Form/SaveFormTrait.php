<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Form;

use Kosv\Yii2Grid\RowEditable\Config\EditConfigInterface;
use yii\helpers\ArrayHelper;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
trait SaveFormTrait
{
    private $editableRowsErrors = [];

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        $rowsAttribute = static::getLoadEditableRowsAttribute();
        if ($name == $rowsAttribute) {
            $this->{$rowsAttribute} = $value;
            return;
        }

        parent::__set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->initSaveForm();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [static::getLoadEditableRowsAttribute(), 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addEditableRowsError($index, $key, $attribute, $message)
    {
        $errors = &$this->editableRowsErrors;
        $keys = [$index, $key, $attribute];

        while (count($keys) > 0) {
            $key = array_shift($keys);
            if (!isset($errors[$key])) {
                $errors[$key] = [];
            }
            $errors = &$errors[$key];
        }

        $errors[] = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function clearEditableRowsErrors($index = null, $key = null, $attribute = null)
    {
        if ($index === null) {
            $this->editableRowsErrors = [];
            return;
        }
        if ($key === null) {
            unset($this->editableRowsErrors[$index]);
            return;
        }
        if ($attribute === null) {
            unset($this->editableRowsErrors[$index][$key]);
            return;
        }

        unset($this->editableRowsErrors[$index][$key][$attribute]);
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableRowsErrors($index = null, $key = null, $attribute = null)
    {
        $errors = $this->editableRowsErrors;

        if ($index === null) {
            return $errors;
        }
        if ($key === null) {
            return ArrayHelper::getValue($errors, "{$index}", []);
        }
        if ($attribute === null) {
            return ArrayHelper::getValue($errors, "{$index}.{$key}", []);
        }

        return ArrayHelper::getValue($errors, "{$index}.{$key}.{$attribute}", []);
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableRowsFirstError($index = null, $key = null, $attribute = null)
    {
        $errors = $this->getEditableRowsErrors($index, $key, $attribute);
        return count($errors) ? array_shift($errors) : '';
    }

    /**
     * {@inheritdoc}
     */
    public static function getLoadEditableRowsAttribute()
    {
        return EditConfigInterface::DEFAULT_LOAD_ROWS_ATTRIBUTE;
    }

    /**
     * {@inheritdoc}
     */
    public function hasEditableRowsErrors($index = null, $key = null, $attribute = null)
    {
        return !empty($this->getEditableRowsErrors($index, $key, $attribute));
    }

    /**
     * @return void
     */
    protected function initSaveForm()
    {
        $rowsAttribute = static::getLoadEditableRowsAttribute();
        if (!isset($this->{$rowsAttribute})) {
            $this->{$rowsAttribute} = [];
        }
    }
}