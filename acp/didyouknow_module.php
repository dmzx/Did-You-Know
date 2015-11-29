<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\acp;

class didyouknow_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $phpbb_container, $phpbb_extension_manager, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$table_did_you_know = $phpbb_container->getParameter('dmzx.didyouknow.table.did.you.know');

		include_once($phpbb_root_path . 'includes/functions_posting.' . $phpEx);
		include_once($phpbb_root_path . 'includes/functions_display.' . $phpEx);
		include_once($phpbb_root_path . 'includes/functions_content.' . $phpEx);
		include_once($phpbb_root_path . 'includes/message_parser.' . $phpEx);

		$user->add_lang(array('posting'));

		// Set up general vars
		$action = $request->variable('action', '');
		$action = (isset($_POST['add'])) ? 'add' : ((isset($_POST['save'])) ? 'save' : $action);

		$s_hidden_fields = '';
		$word_edit = array();

		$this->tpl_name = 'acp_did_you_know';
		$this->page_title = 'ACP_DYK_TITLE';

		$form_name = 'acp_did_you_know';
		add_form_key($form_name);

		display_custom_bbcodes();
		generate_smilies('inline', '' ,1);

		switch ($action)
		{
			case 'edit':

				$word_id = $request->variable('id', 0);

				if (!$word_id)
				{
					trigger_error($user->lang['ACP_DYK_NO_WORD'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'SELECT *
					FROM ' . $table_did_you_know . "
					WHERE word_id = $word_id";
				$result = $db->sql_query_limit($sql, 1);
				$word_edit = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$s_hidden_fields .= '<input type="hidden" name="id" value="' . $word_id . '" />';

				decode_message($word_edit['word'], $word_edit['bbcode_uid']);

				$template->assign_vars(array(
					'S_EDIT_WORD'		=> true,
				));

			case 'add':

				$sql = 'SELECT *
					FROM ' . LANG_TABLE;
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('lang', array(
						'LANG_NAME'		=> $row['lang_local_name'],
						'LANG_ISO'		=> $row['lang_iso'],
					));
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_ADD_WORD'		=> (isset($word_edit['word'])) ? false : true,
					'S_BBCODE_CHECKED'	=> true,
					'S_SMILIES_CHECKED'	=> true,
					'S_URLS_CHECKED'	=> true,
					'U_ACTION'			=> $this->u_action,
					'U_BACK'			=> $this->u_action,
					'LANGUAGE'			=> (isset($word_edit['lang_iso'])) ? $word_edit['lang_iso'] : 'default',
					'WORD'				=> (isset($word_edit['word'])) ? $word_edit['word'] : '',
					'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
				));

				return;

			break;

			case 'save':

				if (!check_form_key($form_name))
				{
					trigger_error($user->lang['ACP_DYK_FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
				}

				$word_id		= $request->variable('id', 0);
				$word			= $request->variable('message', '', true);

				$uid = $bitfield = $options = '';
				$allow_bbcode = $allow_urls = $allow_smilies = true;
				generate_text_for_storage($word, $uid, $bitfield, $options, $request->variable('parse_bbcode', false), $request->variable('parse_urls', false), $request->variable('parse_smilies', false));

				if (!$word)
				{
					trigger_error($user->lang['ACP_DYK_ENTER_WORD'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql_ary = array(
					'word'				=> $word,
					'bbcode_uid'		=> $uid,
					'bbcode_bitfield'	=> $bitfield,
					'bbcode_options'	=> $options,
					'lang_iso'			=> $request->variable('lang_iso', 'default'),
				);

				if ($word_id)
				{
					$db->sql_query('UPDATE ' . $table_did_you_know . '
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
						WHERE word_id = $word_id");

					add_log('admin', 'LOG_DYK_SAVE', str_replace('%', '*', $word_id));
				}
				else
				{
					$db->sql_query('INSERT INTO ' . $table_did_you_know . ' ' . $db->sql_build_array('INSERT', $sql_ary));

					add_log('admin', 'LOG_DYK_SAVE_NEW');
				}

				$message = ($word_id) ? $user->lang['ACP_DYK_WORD_UPDATED'] : $user->lang['ACP_DYK_WORD_ADDED'];
				trigger_error($message . adm_back_link($this->u_action));

			break;

			case 'delete':

				$word_id = $request->variable('id', 0);

				if (!$word_id)
				{
					trigger_error($user->lang['ACP_DYK_NO_WORD'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (confirm_box(true))
				{
					$sql = 'SELECT word
						FROM ' . $table_did_you_know . "
						WHERE word_id = $word_id";
					$result = $db->sql_query($sql);
					$deleted_word = $db->sql_fetchfield('word');
					$db->sql_freeresult($result);

					$sql = 'DELETE FROM ' . $table_did_you_know . "
						WHERE word_id = $word_id";
					$db->sql_query($sql);

					add_log('admin', 'LOG_DYK_DELETE', str_replace('%', '*', $word_id));

					trigger_error($user->lang['ACP_DYK_WORD_REMOVED'] . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'id'		=> $word_id,
						'action'	=> 'delete',
					)));
				}

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
		));

		$sql = 'SELECT dyk.*, l.lang_local_name
			FROM ' . $table_did_you_know . ' dyk
			LEFT JOIN ' . LANG_TABLE . ' l
				ON dyk.lang_iso = l.lang_iso
			ORDER BY dyk.word_id ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('words', array(
				'LANGUAGE'		=> (isset($row['lang_local_name'])) ? $row['lang_local_name'] : $user->lang['LANGUAGE_SET_DEFAULT'],
				'WORD'			=> $word = generate_text_for_display($row['word'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
				'WORD_ID'		=> $row['word_id'],
				'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' . $row['word_id'],
				'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;id=' . $row['word_id'],
			));
		}
		$db->sql_freeresult($result);

		// Version check
		$user->add_lang(array('install', 'acp/extensions', 'migrator'));
		$ext_name = 'dmzx/didyouknow';
		$md_manager = new \phpbb\extension\metadata_manager($ext_name, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path);
		try
		{
			$this->metadata = $md_manager->get_metadata('all');
		}
		catch(\phpbb\extension\exception $e)
		{
			trigger_error($e, E_USER_WARNING);
		}
		$md_manager->output_template_data();
		try
		{
			$updates_available = $this->version_check($md_manager, $request->variable('versioncheck_force', false));
			$template->assign_vars(array(
				'S_UP_TO_DATE'		=> empty($updates_available),
				'S_VERSIONCHECK'	=> true,
				'UP_TO_DATE_MSG'	=> $user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
			));
			foreach ($updates_available as $branch => $version_data)
			{
				$template->assign_block_vars('updates_available', $version_data);
			}
		}
		catch (\RuntimeException $e)
		{
			$template->assign_vars(array(
				'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
				'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
			));
		}
	}

	protected function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false)
	{
		global $user, $cache, $config;
		$meta = $md_manager->get_metadata('all');
		if (!isset($meta['extra']['version-check']))
		{
			throw new \RuntimeException($this->user->lang('NO_VERSIONCHECK'), 1);
		}
		$version_check = $meta['extra']['version-check'];
		$version_helper = new \phpbb\version_helper($cache, $config, new \phpbb\file_downloader(), $user);
		$version_helper->set_current_version($meta['version']);
		$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename']);
		$version_helper->force_stability($config['extension_force_unstable'] ? 'unstable' : null);
		return $updates = $version_helper->get_suggested_updates($force_update, $force_cache);
	}
}
