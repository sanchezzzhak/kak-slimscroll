<?php
namespace kak\widgets\panel;

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
