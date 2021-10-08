<?php

namespace ThemeHouse\ActivationReminderPurger;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Create;

/**
 * Class Setup
 * @package ThemeHouse\ActivationReminderPurger
 */
class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    /**
     *
     */
    public function installStep1()
    {
        $this->schemaManager()->createTable('xf_th_arp_activation_reminder', function (Create $table) {
            $table->addColumn('user_id', 'int');
            $table->addColumn('send_date', 'int')->setDefault(0);
            $table->addPrimaryKey('user_id');
        });
    }

    public function postInstall(array &$stateChanges)
    {
        \XF::app()->jobManager()->enqueueUnique('thARP_activationReminderEmail',
                'ThemeHouse\ActivationReminderPurger:UserPurger');
    }

    public function upgrade1000091Step1()
    {
        if (!$this->schemaManager()->tableExists('xf_th_arp_activation_reminder')) {
            $this->schemaManager()->createTable('xf_th_arp_activation_reminder', function (Create $table) {
                $table->addColumn('user_id', 'int');
                $table->addColumn('send_date', 'int')->setDefault(0);
                $table->addPrimaryKey('user_id');
            });
        }
    }

    /**
     *
     */
    public function uninstallStep1()
    {
        $this->schemaManager()->dropTable('xf_th_arp_activation_reminder');
    }
}