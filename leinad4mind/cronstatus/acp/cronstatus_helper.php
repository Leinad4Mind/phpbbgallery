<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus\acp;

class cronstatus_helper
{
	/**
	 * Recursive array sorting based on the second level key
	 *
	 * @param array  $array Array to be sorted
	 * @param string $on    Second level key for sorting
	 * @param int    $order Sorting direction (SORT_ASC, SORT_DESC)
	 * @return array
	 */
	public function array_sort($array, $on, $order = SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (sizeof($array) > 0)
		{
			foreach ($array as $k => $v)
			{
				if (is_array($v))
				{
					foreach ($v as $k2 => $v2)
					{
						if ($k2 == $on)
						{
							$sortable_array[$k] = $v2;
						}
					}
				}
				else
				{
					$sortable_array[$k] = $v;
				}
			}

			switch ($order)
			{
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}

			foreach ($sortable_array as $k => $v)
			{
				$new_array[$k] = $array[$k];
			}
		}
		return $new_array;
	}

	/**
	 * Performs the search for a specific config_name and
	 * returns the corresponding config_value or false if nothing was found
	 * Works like array_search with partial matches
	 *
	 * @param string $needle   The config_name to search for
	 * @param array  $haystack The array to search in
	 * @return mixed
	 */
	public function array_find($needle, $haystack)
	{
		if (!is_array($haystack))
		{
			return false;
		}
		foreach ($haystack as $key => $item)
		{
			if (strpos($item['config_name'], $needle) !== false)
			{
				return $haystack[$key]['config_value'];
			}
		}
		return false;
	}

	/**
	 * Outputs extension metadata into the template
	 *
	 * @param array                    $metadata Array with all metadata for the extension
	 * @param \phpbb\template\template $template phpBB template object
	 */
	public function output_metadata_to_template($metadata, $template)
	{
		$template->assign_vars(array(
			'META_NAME'        => $metadata['name'],
			'META_TYPE'        => $metadata['type'],
			'META_DESCRIPTION' => (isset($metadata['description'])) ? $metadata['description'] : '',
			'META_HOMEPAGE'    => (isset($metadata['homepage'])) ? $metadata['homepage'] : '',
			'META_VERSION'     => $metadata['version'],
			'META_TIME'        => (isset($metadata['time'])) ? $metadata['time'] : '',
			'META_LICENSE'     => $metadata['license'],

			'META_REQUIRE_PHP'      => (isset($metadata['require']['php'])) ? $metadata['require']['php'] : '',
			'META_REQUIRE_PHP_FAIL' => (isset($metadata['require']['php'])) ? false : true,

			'META_REQUIRE_PHPBB'      => (isset($metadata['extra']['soft-require']['phpbb/phpbb'])) ? $metadata['extra']['soft-require']['phpbb/phpbb'] : '',
			'META_REQUIRE_PHPBB_FAIL' => (isset($metadata['extra']['soft-require']['phpbb/phpbb'])) ? false : true,

			'META_DISPLAY_NAME' => (isset($metadata['extra']['display-name'])) ? $metadata['extra']['display-name'] : '',
		));

		foreach ($metadata['authors'] as $author)
		{
			$template->assign_block_vars('meta_authors', array(
				'AUTHOR_NAME'     => $author['name'],
				'AUTHOR_EMAIL'    => (isset($author['email'])) ? $author['email'] : '',
				'AUTHOR_HOMEPAGE' => (isset($author['homepage'])) ? $author['homepage'] : '',
				'AUTHOR_ROLE'     => (isset($author['role'])) ? $author['role'] : '',
			));
		}
	}

	/**
	 * Identifies current Cron task's name and the time of its last execution
	 *
	 * @param array   $rows      Array with fetched parameters for Cron tasks
	 * @param string &$name      Current Cron task's name (to be properly formatted)
	 * @param int    &$task_date Current Cron task's time of its last execution
	 */
	public function get_task_params(array $rows, &$name, &$task_date)
	{
		$find = strpos($name, 'tidy');
		if ($find !== false)
		{
			$name = substr($name, $find + 5);
			$name = ($name == 'sessions') ? 'session' : $name;
			$task_date = (int) $this->array_find($name . '_last_gc', $rows);
		}
		else if (strpos($name, 'prune_notifications') !== false)
		{
			$task_date = (int) $this->array_find('read_notification_last_gc', $rows);
			$name = 'read_notification';
		}
		else if (strpos($name, 'queue') !== false)
		{
			$task_date = (int) $this->array_find('last_queue_run', $rows);
			$name = 'queue_interval';
		}
		else if (strpos($name, 'text_reparser') !== false)
		{
			$name = str_replace('cron.task.', '', $name);
			$task_date = (int) $this->array_find($name . '_last_cron', $rows);
		}
		else if (strpos($name, 'update_hashes') !== false)
		{
			$name = str_replace('cron.task.core.', '', $name);
			$task_date = (int) $this->array_find($name . '_last_cron', $rows);
		}
		else
		{
			$name = (strrpos($name, ".") !== false) ? substr($name, strrpos($name, ".") + 1) : $name;
			$task_last_gc = $this->array_find($name . '_last_gc', $rows);
			$task_date = ($task_last_gc !== false) ? (int) $task_last_gc : -1;
		}
	}

	/**
	 * Calculates next time for Cron task execution
	 *
	 * @param array  $rows      Array with fetched parameters for Cron tasks
	 * @param int    $task_date Microtime of last execution of current Cron task
	 * @param string $name      Name of current Cron task (already normalized by get_task_params())
	 * @return int
	 */
	public function get_new_task_date(array $rows, $task_date, $name)
	{
		if ($task_date <= 0)
		{
			return 0;
		}

		if ($name === 'queue_interval')
		{
			$new_task_interval = $this->array_find('queue_interval', $rows);
		}
		else if (strpos($name, 'text_reparser') !== false)
		{
			$new_task_interval = $this->array_find($name . '_cron_interval', $rows);
		}
		else
		{
			$new_task_interval = $this->array_find($name . '_gc', $rows);
		}

		return ($new_task_interval > 0) ? $task_date + $new_task_interval : 0;
	}

	/**
	 * Resolves a Cron task's name to the name of the config key that stores
	 * the time of its last execution. Used by the "Run Now" action to stamp
	 * a task as ready without waiting for phpBB's own cron beacon.
	 *
	 * Mirrors the mapping in get_task_params(), but returns the config key
	 * itself rather than resolving and fetching its current value.
	 *
	 * @param string $task_name Full Cron task name (e.g. $task->get_name())
	 * @return string
	 */
	public function get_task_last_run_key($task_name)
	{
		$find = strpos($task_name, 'tidy');
		if ($find !== false)
		{
			$name = substr($task_name, $find + 5);
			$name = ($name == 'sessions') ? 'session' : $name;
			return $name . '_last_gc';
		}
		else if (strpos($task_name, 'prune_notifications') !== false)
		{
			return 'read_notification_last_gc';
		}
		else if (strpos($task_name, 'queue') !== false)
		{
			return 'last_queue_run';
		}
		else if (strpos($task_name, 'text_reparser') !== false)
		{
			return str_replace('cron.task.', '', $task_name) . '_last_cron';
		}
		else if (strpos($task_name, 'update_hashes') !== false)
		{
			return str_replace('cron.task.core.', '', $task_name) . '_last_cron';
		}
		else
		{
			$name = (strrpos($task_name, ".") !== false) ? substr($task_name, strrpos($task_name, ".") + 1) : $task_name;
			return $name . '_last_gc';
		}
	}
}
