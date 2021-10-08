<?php

namespace ThemeHouse\ActivationReminderPurger\Cron;

class ActivationReminderEmail
{
    public static function run()
    {
        if (\XF::options()->thactivationreminderpurger_resendTime) {
            \XF::app()->jobManager()->enqueueUnique('thARP_activationReminderEmail',
                'ThemeHouse\ActivationReminderPurger:ActivationReminderEmail');
        }
    }
}