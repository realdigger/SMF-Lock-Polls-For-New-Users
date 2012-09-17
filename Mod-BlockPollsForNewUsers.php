<?php
/**
 * @package SMF Block Polls For New Users
 * @author digger
 * @copyright 2012
 * @license CC BY-NC-ND http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @version 1.0
 */

if (!defined('SMF'))
    die('Hacking attempt...');

add_integration_function('integrate_menu_buttons', 'addLockPollsForNewUsers', false);

function addLockPollsForNewUsers()
{
    global $user_info, $user_profile, $context, $smcFunc, $txt;

    loadLanguage('LockPollsForNewUsers/');

    if ($context['is_poll']) {
        $result = $smcFunc['db_query']('', '
			SELECT UNIX_TIMESTAMP(date_started)
			FROM {db_prefix}polls
			WHERE id_poll = {int:id_poll}',
            array(
                'id_poll' => (int)$context['poll']['id'],
            )
        );

        if (!empty($result)) {
            list ($datePollStarted) = $smcFunc['db_fetch_row']($result);
            $smcFunc['db_free_result']($result);

            loadMemberData($user_info['id']);

            if ($datePollStarted < $user_profile[$user_info['id']]['date_registered'] && !$context['poll']['is_locked'] && !$context['poll']['is_expired']) {
                $context['poll']['allowed_warning'] = '<div class="errorbox">' . $txt['warningLockPollsForNewUsers'] . '</div>';
                $context['poll']['question'] .= '<div class="errorbox">' . $txt['warningLockPollsForNewUsers'] . '</div>';
                $context['allow_vote'] = false;
            }
        }
    }
}

;