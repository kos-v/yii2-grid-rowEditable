<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Select;

use yii\grid\CheckboxColumn as BaseCheckboxColumn;
use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class CheckboxColumn extends BaseCheckboxColumn implements CheckboxColumnInterface
{
    /**
     * @var string
     */
    public $selectAllCssClass = 'gre-select-all';

    /**
     * @var string
     */
    public $selectItemCssClass = 'gre-select-item';

    /**
     * {@inheritdoc}
     */
    public function getSelectAllClass()
    {
        return $this->selectAllCssClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectItemClass()
    {
        return $this->selectItemCssClass;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        Html::addCssClass($this->checkboxOptions, $this->getSelectItemClass());
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null || !$this->multiple) {
            return parent::renderHeaderCellContent();
        }

        return Html::checkbox($this->getHeaderCheckBoxName(), false, [
            'class' => 'select-on-check-all ' . $this->getSelectAllClass(),
        ]);
    }
}