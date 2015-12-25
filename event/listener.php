<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var string */
	protected $did_you_know;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\request\request 			$request
	* @param \phpbb\template\template			$template
	* @param \phpbb\controller\helper			$helper
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\auth\auth					$auth
	* @param									$did_you_know
	*
	*/

	public function __construct(\phpbb\user $user, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $did_you_know)
	{
		$this->user					= $user;
		$this->request 				= $request;
		$this->template				= $template;
		$this->helper 				= $helper;
		$this->db					= $db;
		$this->auth 				= $auth;
		$this->did_you_know 		= $did_you_know;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.permissions'						=> 'add_permission',
			'core.page_header'						=> 'page_header',
			'core.ucp_prefs_personal_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_personal_update_data'	=> 'ucp_prefs_set_data',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dmzx/didyouknow',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_did_you_know'] = array('lang' => 'ACL_U_DID_YOU_KNOW', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function page_header($event)
	{

		if ($this->auth->acl_get('u_did_you_know'))
		{

			$sql_layer = $this->db->get_sql_layer();
			switch ($sql_layer)
			{
				case 'postgres':
					$random = 'RANDOM()';
				break;

				case 'mssql':
				case 'mssql_odbc':
					$random = 'NEWID()';
				break;

				default:
					$random = 'RAND()';
				break;
			}

			$sql = 'SELECT word, bbcode_uid, bbcode_bitfield, bbcode_options
				FROM ' . $this->did_you_know . "
				WHERE lang_iso = '{$this->user->data['user_lang']}'
					OR lang_iso = 'default'
				ORDER BY $random";
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$word = generate_text_for_display($row['word'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']);

			$this->template->assign_vars(array(
				'DID_YOU_KNOW' 	=> str_replace("&quot;", '"', $word),
				'S_DIDYOUKNOW'	=>	!empty($this->user->data['user_didyouknow']) ? true : false,
				'U_DYK_HIDE'	=>	$this->helper->route('dmzx_didyouknow_controller', array('mode' => 'hide')),
			));
		}
	}

	public function ucp_prefs_get_data($event)
	{
		$event['data'] = array_merge($event['data'], array(
			'didyouknow'	=> $this->request->variable('didyouknow', (int) $this->user->data['user_didyouknow']),
		));

		if (!$event['submit'])
		{
			$this->template->assign_vars(array(
				'S_UCP_DIDYOUKNOW'	=> $event['data']['didyouknow'],
			));
		}
	}

	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'user_didyouknow' => $event['data']['didyouknow'],
		));
	}
}
