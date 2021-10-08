<?php

namespace ThemeHouse\ActivationReminderPurger\Listener;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class EntityStructure
{
    public static function xfUser(Manager $em, Structure &$structure)
    {
        $structure->relations['THActivationReminder'] = [
            'type' => Entity::TO_ONE,
            'entity' => 'ThemeHouse\ActivationReminderPurger:ActivationReminder',
            'conditions' => 'user_id'
        ];
    }
}
