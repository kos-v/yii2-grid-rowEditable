<?php
/**
 * @link https://github.com/Konstantin-Vl/yii2-grid-rowEditor
 * @copyright Copyright (c) 2018 Konstantin Voloshchuk
 * @license https://github.com/Konstantin-Vl/yii2-grid-rowEditor/blob/master/LICENSE
 */

namespace Kosv\Yii2Grid\RowEditor;

use Kosv\jFixClone\AssetsBundle as FixCloneAssets;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * @author Konstantin Voloshchuk <kosv.dev@gmail.com>
 * @since 1.0
 */
class AssetsBundle extends AssetBundle
{
    public $sourcePath = "@vendor/kosv/yii2-grid-rowEditor/assets";

    public $depends = [
        JqueryAsset::class,
        FixCloneAssets::class,
    ];

    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/kosv-grid-roweditor.js',
    ];

    public $publishOptions = [
        'forceCopy' => true, //TODO: Remove
    ];
}