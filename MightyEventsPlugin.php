<?php
namespace Craft;

class MightyEventsPlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('Mighty Events');
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getDeveloper()
    {
        return 'Taylor Daughtry';
    }

    public function getDeveloperUrl()
    {
        return 'http://github.com/taylordaughtry';
    }

    public function getPluginName()
    {
        return 'Mighty Events';
    }

    public function getPluginUrl()
    {
        return 'https://github.com/taylordaughtry/mightyevents';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
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
            'url' => UrlHelper::getUrl('mightyevents'),
        );

        $tabs['manage_events'] = array(
            'label' => Craft::t('Manage Events'),
            'url' => UrlHelper::getUrl('mightyevents/manage-events'),
        );

        $tabs['create_event'] = array(
            'label' => Craft::t('Create an Event'),
            'url' => UrlHelper::getUrl('mightyevents/create-event'),
        );

        return $tabs;
    }
}