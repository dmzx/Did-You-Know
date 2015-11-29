<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\migrations;

class didyouknow_schema extends \phpbb\db\migration\migration
{
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
}
