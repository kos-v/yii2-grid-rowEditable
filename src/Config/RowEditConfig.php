<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor\Config;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class RowEditConfig extends BaseObject implements RowEditConfigInterface
{
    /**
     * @var Model
     */
    public $form;

    /**
     * @var string
     */
    public $formAttribute = 'editingRows';

    /**
     * @var \Closure|array|string
     */
    public $input = self::INPUT_TYPE_INPUT;

    /**
     * @var string
     */
    public $inputWrapHtmlClass = 're-input-wrap';

    /**
     * @var string
     */
    public $inputWrapHtmlTag = 'div';

    /**
     * @var string
     */
    public $outputWrapHtmlClass = 're-output-wrap';

    /**
     * @var string
     */
    public $outputWrapHtmlTag = 'div';

    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->form instanceof Model) {
            throw new InvalidConfigException(
                static::class . '::form property must be instance ' . Model::class
            );
        }

        if (!$this->formAttribute) {
            throw new InvalidConfigException(
                static::class .
                "::formAttribute property must be have attribute name from the " .
                get_class($this->form)
            );
        }
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function merge($config)
    {
        if ($config) {
            $publicProps = (new \ReflectionObject($this))
                ->getProperties(\ReflectionProperty::IS_PUBLIC);
            $publicProps = ArrayHelper::getColumn($publicProps, 'name');

            foreach ($config as $configKey => $configValue) {
                if (!in_array($configKey, $publicProps)) {
                    throw new UnknownPropertyException(
                        'Setting unknown property: ' . static::class . "::{$configKey}"
                    );
                }
                $this->{$configKey} = $configValue;
            }
        }

        return $this;
    }
}