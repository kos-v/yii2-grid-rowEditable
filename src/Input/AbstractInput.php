<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Input;

use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
abstract class AbstractInput implements InputInterface
{
    /**
     * @var InputDto
     */
    protected $inputDto;

    /**
     * @param InputDto $inputDto
     * @param array $params
     */
    public function __construct(InputDto $inputDto, $params = [])
    {
        parent::__construct($inputDto, $params);
        $this->inputDto = $inputDto;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Html::getInputName($this->inputDto->form, $this->inputDto->formAttribute)
            . "[{$this->inputDto->index}][{$this->inputDto->key}][{$this->inputDto->attribute}]";
    }
}