<?php
/**
 * @link      www.rework.digital
 * @copyright Copyright (c) 2019 Rework Digital
 */

namespace reworkdigital\adminasseturl\actions;

use Craft;
use craft\base\ElementAction;
use craft\base\ElementInterface;
use craft\helpers\Json;
use yii\base\Exception;

/**
 * AssetUrlAction represents a display asset url element action.
 */
class AssetUrlAction extends ElementAction
{
    // Properties
    // =========================================================================

    /**
     * @var string|null The element type associated with this action
     */
    public $elementType;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Craft::t('app', 'Copy asset url');
    }

    /**
     * @inheritdoc
     */
    public function getTriggerHtml()
    {
        $type = Json::encode(static::class);
        $prompt = Json::encode(Craft::t('app', '{ctrl}C to copy.'));
        /** @var string|ElementInterface $elementType */
        $elementType = $this->elementType;

        if (($refHandle = $elementType::refHandle()) === null) {
            throw new Exception("Element type \"{$elementType}\" doesn't have a reference handle.");
        }

        $js = <<<EOD
(function()
{
    var trigger = new Craft.ElementActionTrigger({
        type: {$type},
        batch: false,
        activate: function(\$selectedItems)
        {
            var message = Craft.t('app', {$prompt}, {
                ctrl: (navigator.appVersion.indexOf('Mac') !== -1 ? '⌘' : 'Ctrl-')
            });

            prompt(message, \$selectedItems.find('.element').data('url'));
        }
    });
})();
EOD;
        Craft::$app->getView()->registerJs($js);
    }
}
