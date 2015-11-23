<?php

class ThemeHouse_EmailAdGenPass_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_EmailAdGenPass' => array(
                'datawriter' => array(
                    'XenForo_DataWriter_User'
                ),
            ),
        );
    } /* END _getExtendedClasses */

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_EmailAdGenPass_Listener_LoadClass', $class, $extend, 'datawriter');
    } /* END loadClassDataWriter */
}