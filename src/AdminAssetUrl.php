<?php
/**
 * Admin Asset URL plugin for Craft CMS 3.x
 *
 * Displays a 'copy asset url' option in the action dropdown for assets in the admin panel, useful for external linking.
 *
 * @link      www.rework.digital
 * @copyright Copyright (c) 2019 Rework Digital
 */

namespace reworkdigital\adminasseturl;

use craft\base\Element;
use craft\base\Plugin;
use craft\elements\Asset;
use craft\events\RegisterElementActionsEvent;

use reworkdigital\adminasseturl\actions\AssetUrlAction;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Rework Digital
 * @package   AdminAssetUrl
 * @since     1.0.0
 *
 */
class AdminAssetUrl extends Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * AdminAssetUrl::$plugin
     *
     * @var AdminAssetUrl
     */
    public static $plugin;

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(Asset::class, Element::EVENT_REGISTER_ACTIONS, [$this, 'registerAssetUrlAction']);
    }

    /**
     * Handler for the Element::EVENT_REGISTER_ACTIONS event.
     */
    public function registerAssetUrlAction(RegisterElementActionsEvent $event)
    {
        $event->actions[] = AssetUrlAction::class;
    }

}
