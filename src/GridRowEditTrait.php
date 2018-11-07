<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor;

use Kosv\Yii2Grid\RowEditor\Config\RowEditConfig;
use Kosv\Yii2Grid\RowEditor\Config\RowEditConfigInterface;

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
     * @var RowEditConfigInterface
     */
    protected $rowEditConfig;

    /**
     * @return RowEditConfigInterface
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
    }

    /**
     * @return string
     */
    protected function getDefaultEditColumnClass()
    {
        return RowEditColumn::class;
    }

    /**
     * @return string
     */
    protected function getDefaultEditConfigClass()
    {
        return RowEditConfig::class;
    }
}