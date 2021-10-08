<?php

namespace ThemeHouse\ActivationReminderPurger\Cron;

class UserPurger
{
    public static function run()
    {
        if (\XF::options()->thactivationreminderpurger_purgeTime) {
            \XF::app()->jobManager()->enqueueUnique('thARP_activationReminderEmail',
                'ThemeHouse\ActivationReminderPurger:UserPurger');
        }
    }
}