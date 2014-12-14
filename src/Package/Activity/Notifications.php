<?php
/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Activity;

use Joomla\Github\AbstractPackage;
use Joomla\Date\Date;

/**
 * GitHub API Activity Events class for the Joomla Framework.
 *
 * @documentation http://developer.github.com/v3/activity/notifications/
 *
 * @since  1.0
 */
class Notifications extends AbstractPackage
{
	/**
	 * List your notifications.
	 *
	 * List all notifications for the current user, grouped by repository.
	 *
	 * @param   boolean  $all            True to show notifications marked as read.
	 * @param   boolean  $participating  True to show only notifications in which the user is directly participating or
	 *                                   mentioned.
	 * @param   Date     $since          filters out any notifications updated before the given time. The time should be passed in
	 *                                   as UTC in the ISO 8601 format.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getList($all = true, $participating = true, Date $since = null)
	{
		// Build the request path.
		$path = '/notifications?';

		$path .= ($all) ? '&all=1' : '';
		$path .= ($participating) ? '&participating=1' : '';
		$path .= ($since) ? '&since=' . $since->toISO8601() : '';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * List your notifications in a repository.
	 *
	 * List all notifications for the current user.
	 *
	 * @param   string   $owner          Repository owner.
	 * @param   string   $repo           Repository name.
	 * @param   boolean  $all            True to show notifications marked as read.
	 * @param   boolean  $participating  True to show only notifications in which the user is directly participating or
	 *                                   mentioned.
	 * @param   Date     $since          filters out any notifications updated before the given time. The time should be passed in
	 *                                   as UTC in the ISO 8601 format.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListRepository($owner, $repo, $all = true, $participating = true, Date $since = null)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/notifications?';

		$path .= ($all) ? '&all=1' : '';
		$path .= ($participating) ? '&participating=1' : '';
		$path .= ($since) ? '&since=' . $since->toISO8601() : '';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Mark as read.
	 *
	 * Marking a notification as “read” removes it from the default view on GitHub.com.
	 *
	 * @param   boolean  $unread        Changes the unread status of the threads.
	 * @param   boolean  $read          Inverse of “unread”.
	 * @param   Date     $last_read_at  Describes the last point that notifications were checked.
	 *                                  Anything updated since this time will not be updated. Default: Now. Expected in ISO 8601 format.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function markRead($unread = true, $read = true, Date $last_read_at = null)
	{
		// Build the request path.
		$path = '/notifications';

		$data = array(
			'unread' => $unread,
			'read'   => $read
		);

		if ($last_read_at)
		{
			$data['last_read_at'] = $last_read_at->toISO8601();
		}

		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data)),
			205
		);
	}

	/**
	 * Mark notifications as read in a repository.
	 *
	 * Marking all notifications in a repository as “read” removes them from the default view on GitHub.com.
	 *
	 * @param   string   $owner         Repository owner.
	 * @param   string   $repo          Repository name.
	 * @param   boolean  $unread        Changes the unread status of the threads.
	 * @param   boolean  $read          Inverse of “unread”.
	 * @param   Date     $last_read_at  Describes the last point that notifications were checked.
	 *                                  Anything updated since this time will not be updated. Default: Now. Expected in ISO 8601 format.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function markReadRepository($owner, $repo, $unread, $read, Date $last_read_at = null)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/notifications';

		$data = array(
			'unread' => $unread,
			'read'   => $read
		);

		if ($last_read_at)
		{
			$data['last_read_at'] = $last_read_at->toISO8601();
		}

		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data)),
			205
		);
	}

	/**
	 * View a single thread.
	 *
	 * @param   integer  $id  The thread id.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function viewThread($id)
	{
		// Build the request path.
		$path = '/notifications/threads/' . $id;

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Mark a thread as read.
	 *
	 * @param   integer  $id      The thread id.
	 * @param   boolean  $unread  Changes the unread status of the threads.
	 * @param   boolean  $read    Inverse of “unread”.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function markReadThread($id, $unread = true, $read = true)
	{
		// Build the request path.
		$path = '/notifications/threads/' . $id;

		$data = array(
			'unread' => $unread,
			'read'   => $read
		);

		return $this->processResponse(
			$this->client->patch($this->fetchUrl($path), json_encode($data)),
			205
		);
	}

	/**
	 * Get a Thread Subscription.
	 *
	 * This checks to see if the current user is subscribed to a thread.
	 * You can also get a Repository subscription.
	 *
	 * @param   integer  $id  The thread id.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getThreadSubscription($id)
	{
		// Build the request path.
		$path = '/notifications/threads/' . $id . '/subscription';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Set a Thread Subscription.
	 *
	 * This lets you subscribe to a thread, or ignore it. Subscribing to a thread is unnecessary
	 * if the user is already subscribed to the repository. Ignoring a thread will mute all
	 * future notifications (until you comment or get @mentioned).
	 *
	 * @param   integer  $id          The thread id.
	 * @param   boolean  $subscribed  Determines if notifications should be received from this thread.
	 * @param   boolean  $ignored     Determines if all notifications should be blocked from this thread.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function setThreadSubscription($id, $subscribed, $ignored)
	{
		// Build the request path.
		$path = '/notifications/threads/' . $id . '/subscription';

		$data = array(
			'subscribed' => $subscribed,
			'ignored'    => $ignored
		);

		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data))
		);
	}

	/**
	 * Delete a Thread Subscription.
	 *
	 * @param   integer  $id  The thread id.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function deleteThreadSubscription($id)
	{
		// Build the request path.
		$path = '/notifications/threads/' . $id . '/subscription';

		return $this->processResponse(
			$this->client->delete($this->fetchUrl($path)),
			204
		);
	}
}