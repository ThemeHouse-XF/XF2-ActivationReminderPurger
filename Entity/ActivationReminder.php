<?php

namespace ThemeHouse\ActivationReminderPurger\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ActivationReminder extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->shortName = 'ThemeHouse\ActivationReminderPurger:ActivationReminder';
        $structure->primaryKey = 'user_id';
        $structure->table = 'xf_th_arp_activation_reminder';

        $structure->columns = [
            'user_id' => ['type' => self::UINT],
            'send_date' => ['type' => self::UINT, 'default' => \XF::$time]
        ];

        $structure->relations = [
            'User' => [
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true,
                'entity' => 'XF:User'
            ]
        ];

        $structure->defaultWith = ['User'];

        return $structure;
    }
}