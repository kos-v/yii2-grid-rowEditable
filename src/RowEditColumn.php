<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor;

use Kosv\Yii2Grid\RowEditor\Config\RowEditConfig;
use Kosv\Yii2Grid\RowEditor\Config\RowEditConfigInterface;
use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class RowEditColumn extends DataColumn
{
    /**
     * @var array
     */
    public $editParams = [];

    /**
     * @var RowEditConfig
     */
    protected $editConfig;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->editConfig = $this->getCommonEditConfig()->merge($this->editParams);
    }

    /**
     * @return RowEditConfigInterface
     */
    protected function getCommonEditConfig()
    {
        /** @var GridRowEditInterface $grid */
        $grid = $this->grid;
        if ($this->editParams) {
            return clone $grid->getRowEditConfig();
        }

        return $grid->getRowEditConfig();
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $displayValue = Html::tag(
            $this->editConfig->outputWrapHtmlTag,
            parent::renderDataCellContent($model, $key, $index),
            ['class' => $this->editConfig->outputWrapHtmlClass]
        );

        $editInput = Html::tag(
            $this->editConfig->inputWrapHtmlTag,
            $this->renderDataCellEditInput($model, $key, $index),
            ['class' => $this->editConfig->inputWrapHtmlClass]
        );

        return $displayValue . $editInput;
    }

    protected function renderDataCellEditInput($model, $key, $index)
    {
        $html = '';
        $input = $this->editConfig->input;
        if (is_string($input)) {
            $html = strval(new $input($this->attribute, $key, $index));
        } elseif (is_array($input)) {

        } elseif ($input instanceof \Closure) {

        }

        return $html;
    }

    protected function getEditInputName($model, $key, $index)
    {
        return Html::getInputName($this->editConfig->form, $this->editConfig->formAttribute)
            . "[{$index}][{$key}][{$this->attribute}]";
    }
}