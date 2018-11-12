<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor;

use Kosv\Yii2Grid\RowEditor\Config\RowEditConfig;
use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
trait GridRowEditTrait
{
    /**
     * @var array
     */
    public $commonEditParams = [];

    /**
     * @var RowEditConfig
     */
    protected $rowEditConfig;

    /**
     * @return string
     */
    public function getDefaultEditColumnClass()
    {
        return RowEditColumn::class;
    }

    /**
     * @return string
     */
    public function getDefaultEditConfigClass()
    {
        return RowEditConfig::class;
    }

    /**
     * @return RowEditConfig
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
    public function run()
    {
        $this->runRowEditor();
        parent::run();
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

    }
}