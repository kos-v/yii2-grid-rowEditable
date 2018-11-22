<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Input;

use yii\base\BaseObject;
use yii\helpers\Html;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
abstract class AbstractInput extends BaseObject implements InputInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var InputDto
     */
    protected $inputDto;

    /**
     * {@inheritdoc}
     */
    public function __construct(InputDto $inputDto, $params = [])
    {
        parent::__construct($params);
        $this->inputDto = $inputDto;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name ?:
            Html::getInputName($this->inputDto->form, $this->inputDto->formAttribute)
            . "[{$this->inputDto->index}][{$this->inputDto->key}][{$this->inputDto->attribute}]";
    }

    /**
     * @return string
     */
    public function getValue()
    {
        $attribute = $this->inputDto->attribute;
        return $this->inputDto->model->{$attribute};
    }
}