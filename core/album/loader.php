<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\album;

class loader
{
	/** @var \phpbb\db\driver\driver */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var string */
	protected string $table_albums;

	/** @var array */
	protected array $data = [];

	/** @var \phpbbgallery\core\contest */
	protected \phpbbgallery\core\contest $contest;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db           Database object
	 * @param \phpbb\user                                               $user         User object
	 * @param \phpbbgallery\core\contest                                $contest      Gallery contest object
	 * @param string                                                    $albums_table Gallery albums table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbbgallery\core\contest $contest, string $albums_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->contest = $contest;
		$this->table_albums = $albums_table;
	}

	/**
	* Load the data of an album
	*
	* @param	int		$album_id
	* @return	bool	True if the album was loaded
	* @throws	\OutOfBoundsException	if the album does not exist
	*/
	public function load(int $album_id): bool
	{
		$sql_array = [
			'SELECT'		=> 'a.*',
			'FROM'			=> [$this->table_albums => 'a'],
			'WHERE'			=> 'a.album_id = ' . (int) $album_id,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			throw new \OutOfBoundsException('INVALID_ALBUM');
		}
		if ($row['album_type'] == (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			$album_contest_data = $this->contest->get_contest($row['album_id'], 'album');
			$row = array_merge($row, $album_contest_data);
		}

		$this->data[$album_id] = $row;

		return true;
	}

	/**
	 * Get the value of an album
	 *
	 * @param    int   $album_id
	 * @param    string|null $column_name Name of the column,
	 *                              if null an array with all columns will be returned
	 * @return mixed
	 * @throws    \OutOfBoundsException    if the album does not exist
	 * @throws    \OutOfRangeException    if $column_name does not exist
	 */
	public function get(int $album_id, string|null $column_name = null): mixed
	{
		$album_id = (int) $album_id;
		if (!isset($this->data[$album_id]))
		{
			$this->load($album_id);
		}

		if ($column_name === null)
		{
			return $this->data[$album_id];
		}

		if (!isset($this->data[$album_id][$column_name]))
		{
			throw new \OutOfRangeException('INVALID_ALBUM_COLUMN');
		}

		return $this->data[$album_id][$column_name];
	}

	/**
	* Check whether the album_user is the user who wants to do something
	*
	* @param	int		$album_id
	* @param	int|false	$user_id	If false the current user will be compared
	* @return	bool	True if the user is the owner of the album
	* @throws	\DomainException	if the user is not the owner of the album
	*/
	public function validate_owner(int $album_id, int|false $user_id = false): bool
	{
		$album_id = (int) $album_id;
		$user_id = (int) ($user_id ?: $this->user->data['user_id']);

		if ($this->get($album_id, 'album_user_id') != $user_id)
		{
			throw new \DomainException('INVALID_ALBUM');
		}

		return true;
	}
}
