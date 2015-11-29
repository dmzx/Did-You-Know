<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\controller;

class main
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $phpEx;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\request\request		 		$request
	* @param									$phpbb_root_path
	* @param									$phpEx
	*
	*/

	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, $phpbb_root_path, $phpEx)
	{
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->phpbb_root_path 		= $phpbb_root_path;
		$this->phpEx 				= $phpEx;
	}

	public function handle_didyouknow()
	{
		$mode = $this->request->variable('mode', '');

		switch( $mode )
		{
			case 'hide':
				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_didyouknow = 0
					WHERE user_id = ' . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);

				$message = $this->user->lang['DIDYOUKNOW_HIDE'] . '<br /><br /><a href="' . append_sid("{$this->phpbb_root_path}index.$this->phpEx") . '">' . $this->user->lang['DIDYOUKNOW_BACK_TO_INDEX'] . '</a>';
				trigger_error($message);
			break;
		}
	}
}
