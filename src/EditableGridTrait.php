<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable;

use Closure;
use Kosv\Yii2Grid\RowEditable\Config\EditConfig;
use Kosv\Yii2Grid\RowEditable\Config\EditConfigInterface;
use Kosv\Yii2Grid\RowEditable\Select\CheckboxColumnInterface;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
trait EditableGridTrait
{
    /**
     * @var array
     */
    public $commonEditParams = [];

    /**
     * @var EditConfig
     */
    protected $rowEditConfig;

    /**
     * @return string
     */
    public function getDefaultEditColumnClass()
    {
        return EditableRowColumn::class;
    }

    /**
     * @return string
     */
    public function getDefaultEditConfigClass()
    {
        return EditConfig::class;
    }

    /**
     * @return \yii\grid\Column|null
     */
    public function getFirstColumnByType($className)
    {
        foreach ($this->columns as $column) {
            if ($column instanceof $className) {
                return $column;
            }
        }

        return null;
    }

    /**
     * @return EditConfig
     */
    public function getRowEditConfig()
    {
        return $this->rowEditConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->initRowEditor();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column \yii\grid\Column */
        foreach ($this->columns as $column) {
            $cells[] = $column->renderDataCell($model, $key, $index);
        }
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;
        $options["data-{$this->rowEditConfig->prefix}-selected"] = 'false';

        return Html::tag('tr', implode('', $cells), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->runRowEditor();
        parent::run();
    }

    /**
     * @return array
     */
    protected function getRowEditorSelectParams()
    {
        $selectParams = [];

        $selectMode = EditConfigInterface::SELECT_MODE_CHECKBOX;
        if ($this->rowEditConfig->selectMode & $selectMode) {
            /** @var CheckboxColumnInterface $column */
            $column = $this->getFirstColumnByType(CheckboxColumnInterface::class);
            if (!$column) {
                throw new \UnexpectedValueException(
                    'When the SELECT_MODE_CHECKBOX mode is on, ' .
                    'object ' . static::class . ' must contain a column with ' .
                    'the implementation of ' . CheckboxColumnInterface::class
                );
            }
            $selectParams[$selectMode] = [
                'itemSelector' => '.' . $column->getSelectItemClass(),
                'allSelector' => '.' . $column->getSelectAllClass(),
            ];
        }

        return $selectParams;
    }

    /**
     * @return void
     */
    protected function initRowEditor()
    {
        if (!$this->dataColumnClass) {
            $this->dataColumnClass = $this->getDefaultEditColumnClass();
        }

        $commonEditParams = $this->commonEditParams;
        $configClass = $this->getDefaultEditConfigClass();
        if (isset($rowEditParams['class'])) {
            $configClass = $commonEditParams['class'];
            unset($commonEditParams['class']);
        }
        $this->rowEditConfig = new $configClass($commonEditParams);

        Html::addCssClass($this->options, $this->rowEditConfig->gridCssClass);
    }

    /**
     * @return void
     */
    protected function runRowEditor()
    {
        /** @var \yii\web\View $view */
        $view = $this->getView();
        AssetsBundle::register($view);

        $jsGreSelector = '#' . $this->options['id'];
        $jsGreParams = [
            'inputWrapHtmlClass' => $this->rowEditConfig->inputWrapHtmlClass,
            'prefix' => $this->rowEditConfig->prefix,
            'saveAction' => $this->rowEditConfig->saveAction,
            'saveButton' => $this->rowEditConfig->saveButton,
            'saveMethod' => $this->rowEditConfig->saveMethod,
            'selectMode' => $this->rowEditConfig->selectMode,
            'selectParams' => $this->getRowEditorSelectParams(),
        ];
        $jsGreParams = Json::encode($jsGreParams);

        $view->registerJs("new kosv.GridRowEditor('{$jsGreSelector}', {$jsGreParams});");
    }
}