<?php
namespace kak\widgets\slimscroll;

use yii\web\AssetBundle;

class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/slimscroll';
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $js = [
        'jquery.slimscroll.min.js'
    ];

    public function init()
    {
        parent::init();
    }
} 
