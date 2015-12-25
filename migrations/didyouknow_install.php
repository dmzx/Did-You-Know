<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\migrations;

class didyouknow_install extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(

			// Add permissions
			array('permission.add', array('u_did_you_know', true)),

			// Set permissions
			array('permission.permission_set', array('REGISTERED', 'u_did_you_know', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_did_you_know', 'group')),

			//Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'DYK_TITLE'
			)),
			array('module.add', array(
				'acp',
				'DYK_TITLE',
				array(
					'module_basename'	=> '\dmzx\didyouknow\acp\didyouknow_module',
					'modes'	=>	array('did_you_know'),
				),
			)),

			// Insert sample data
			array('custom', array(
				array(&$this, 'insert_sample_data')
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'did_you_know'	=> array(
					'COLUMNS'	=> array(
						'word_id'			=> array('UINT', null, 'auto_increment'),
						'word'				=> array('MTEXT_UNI', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_options'	=> array('USINT', '0'),
						'lang_iso'			=> array('VCHAR:30', 'default'),
					),
					'PRIMARY_KEY'	=> 'word_id',
				),
			),
			'add_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_didyouknow'	=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'did_you_know',
			),
			'drop_columns' => array(
				$this->table_prefix . 'users'	=> array(
					'user_didyouknow',
				),
			),
		);
	}

	public function insert_sample_data()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'did_you_know'))
		{
			$sql_ary = array(
				array(
					'word_id' 			=> '1',
					'word' 				=> 'Testtext',
					'bbcode_uid' 		=> '',
					'bbcode_bitfield' 	=> '',
					'bbcode_options' 	=> '7',
					'lang_iso' 			=> 'default',
				),
			);
			// Insert sample data
			$this->db->sql_multi_insert($this->table_prefix . 'did_you_know', $sql_ary);
		}
	}
}
