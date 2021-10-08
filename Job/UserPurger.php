<?php

namespace ThemeHouse\ActivationReminderPurger\Job;

use XF\Entity\User;
use XF\Job\AbstractRebuildJob;

class UserPurger extends AbstractRebuildJob
{
    /**
     * @param $start
     * @param $batch
     * @return array
     */
    protected function getNextIds($start, $batch)
    {
        $threshold = \XF::$time - \XF::options()->thactivationreminderpurger_purgeTime * 60 * 60 * 24;
        $db = $this->app->db();

        return array_column($db->fetchAll($db->limit(
            "
				SELECT
				  user_id
                FROM
                  xf_user
                WHERE
                  register_date < ?
                  AND user_id > ?
                  AND user_state = 'email_confirm'
                ORDER BY 
                  user_id
			", $batch
        ), [$threshold, $start]), 'user_id');
    }

    /**
     * @param $id
     */
    protected function rebuildById($id)
    {
        /** @var User $user */
        $user = \XF::em()->find('XF:User', $id);

        if (!$user
            || $user->is_admin
            || $user->is_moderator) {
            return;
        }

        try {
            $user->delete();
        }
        catch(\Throwable $e) {
            \XF::logException($e);
        }
    }

    /**
     * @return null
     */
    protected function getStatusType()
    {
        return null;
    }

    /**
     * @return string|\XF\Phrase
     */
    public function getStatusMessage()
    {
        return \XF::phrase('tharp_purging_inactive_users');
    }
}