<?php
namespace Craft;

class MightyEventsPlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('Mighty Events');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Taylor Daughtry';
    }

    function getDeveloperUrl()
    {
        return 'http://github.com/taylordaughtry';
    }

    function hasCpSection()
    {
        return true;
    }
}