<?php
namespace Craft;

class EventHelperPlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('Event Helper');
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getDeveloper()
    {
        return 'meBooks';
    }

    public function getDeveloperUrl()
    {
        return 'http://mebooks.co.nz';
    }

    public function getPluginName()
    {
        return 'Event Helper';
    }

    public function getPluginUrl()
    {
        return 'https://github.com/nzmebooks/craft-eventhelper';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function hasCpSection()
    {
        return true;
    }

    public function getCpTabs()
    {
        $tabs = array();

        $tabs['home'] = array(
            'label' => Craft::t('Home'),
            'url' => UrlHelper::getUrl('eventhelper'),
        );

        return $tabs;
    }
}
