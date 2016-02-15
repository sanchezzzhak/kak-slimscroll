<?php
namespace kak\widgets\slimscroll;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * Class SlimScroll
 * @package kak\widgets\slimscroll
 */
class SlimScroll extends \yii\base\Widget
{
    const JS_KEY = 'kak/slimscroll';

    const EVENT_SLIMSCROLL = 'slimscroll';
    const EVENT_SLIMSCROLLING = 'slimscrolling';

    /**
     * SlimScroll options
     * @link http://rocha.la/jQuery-slimScroll
     * @var array()
     */
    public $clientOptions;

    /**
     * Html options
     * @var
     */
    public $options;

    /**
     * Js Events
     * ```php
     *   SlimScrololl::begin([
     *      'events' => [ SlimScroll::EVENT_SLIMSCROLLING => new JsExpression('function(e,pos){}') ]
     *   ]);
     * ```
     * @var array
     */
    public $events = [];

    /**
     * Tag
     * @var string
     */
    public $tag='div';

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] =  $this->id;
        }

        echo Html::beginTag($this->tag, $this->options);
    }

    public function run()
    {
        $view = $this->getView();

        SlimScrollAsset::register($view);

        $options = Json::htmlEncode($this->clientOptions);
        $view->registerJs("jQuery('#{$this->options['id']}').slimScroll($options);");

        $this->registerEvents();

        echo Html::endTag($this->tag);
    }

    /**
     * Register plugin' events.
     */
    protected function registerEvents()
    {
        $view = $this->getView();
        $selector = '#' . $this->options['id'];
        if (count($this->events)) {
            $js = [];
            foreach ($this->events as $event => $callback) {
                if (is_array($callback)) {
                    foreach ($callback as $function) {
                        if (!$function instanceof JsExpression) {
                            $function = new JsExpression($function);
                        }
                        $js[] = "jQuery('$selector').on('$event', $function);";
                    }
                } else {
                    if (!$callback instanceof JsExpression) {
                        $callback = new JsExpression($callback);
                    }
                    $js[] = "jQuery('$selector').on('$event', $callback);";
                }
            }
            if (!empty($js)) {
                $js = implode("\n", $js);
                $view->registerJs($js, $view::POS_READY, self::JS_KEY .'events/'. $this->options['id']);
            }
        }
    }

}