<?php
/**
 * @package SMF Lock Polls For New Users
 * @author digger https://mysmf.net
 * @copyright 2012-2024
 * @license The MIT License (MIT)
 * @version 1.0
 */

if (!defined('SMF')) {
    die('Hacking attempt...');
}

function addLockPollsForNewUsers()
{
    global $user_info, $user_profile, $context, $smcFunc, $txt;

    if (!empty($context['is_poll'])) {
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
        }

        loadMemberData($user_info['id']);

        if (!empty($datePollStarted) && $datePollStarted < $user_profile[$user_info['id']]['date_registered'] && !$context['poll']['is_locked'] && !$context['poll']['is_expired']) {
            loadLanguage('LockPollsForNewUsers/');
            $context['poll']['question'] .= '<div class="errorbox">' . $txt['warningLockPollsForNewUsers'] . '</div>';
            $context['allow_vote'] = false;
        }
    }
}

function addLockPollsForNewUsersCopyright()
{
    global $context;

    if ($context['current_action'] == 'credits') {
        $context['copyrights']['mods'][] = '<a href="https://mysmf.net" title="Lock Polls For New Users">Lock Polls For New Users</a> &copy; 2012-20124 digger';
    }
}

;