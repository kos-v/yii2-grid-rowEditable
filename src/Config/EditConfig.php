<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditable
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditable/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditable\Config;

use Kosv\Yii2Grid\RowEditable\Form\SaveFormInterface;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class EditConfig extends BaseObject implements EditConfigInterface
{
    /**
     * @var bool
     */
    public $enable = true;

    /**
     * @var SaveFormInterface
     */
    public $form;

    /**
     * @var string
     */
    public $formAttribute = EditConfigInterface::DEFAULT_LOAD_ROWS_ATTRIBUTE;

    /**
     * @var string
     */
    public $gridCssClass = 'gre-grid-view';

    /**
     * @var \Closure|array|string
     */
    public $input = EditConfigInterface::INPUT_TYPE_INPUT;

    /**
     * @var string
     */
    public $inputWrapHtmlClass = 'input-wrap';

    /**
     * @var string
     */
    public $inputWrapHtmlTag = 'div';

    /**
     * @var string
     */
    public $prefix = 'gre';

    /**
     * @var string
     */
    public $saveAction = '';

    /**
     * @var string
     */
    public $saveButton;

    /**
     * @var bool
     *
     * TODO: In the future version
     */
    public $saveAjax = false;

    /**
     * @var string
     */
    public $saveMethod = 'POST';

    /**
     * @var int
     */
    public $selectMode = EditConfigInterface::SELECT_MODE_CHECKBOX;

    /**
     * @var string
     */
    public $outputWrapHtmlClass = 'output-wrap';

    /**
     * @var string
     */
    public $outputWrapHtmlTag = 'div';

    /**
     * @var string
     */
    public $validationErrorLayout = <<<HTML
    <p class="gre-validation gre-error-msg">{error}</p>
HTML;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->form instanceof SaveFormInterface) {
            throw new InvalidConfigException(
                static::class . '::form property must be instance ' . SaveFormInterface::class
            );
        }

        if (!$this->formAttribute) {
            throw new InvalidConfigException(
                static::class .
                "::formAttribute property must be have attribute name from the " .
                get_class($this->form)
            );
        }

        if (!$this->saveButton) {
            $this->saveButton = '.' . EditConfigInterface::DEFAULT_CLASS_SAVE_BTN;
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
                if (!in_array($configKey, $publicProps) ||
                    in_array($configKey, $this->getIgnoreMergeProps())) {
                    throw new UnknownPropertyException(
                        'Setting unknown property: ' . static::class . "::{$configKey}"
                    );
                }
                $this->{$configKey} = $configValue;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getIgnoreMergeProps()
    {
        return [
            'prefix', 'gridCssClass', 'selectMode',
            'saveAction', 'saveAjax', 'saveMethod',
            'saveButton',
        ];
    }

    /**
     * @param string $val
     * @return string
     */
    public function getPrefix($val = '')
    {
        return $this->prefix . $val;
    }
}