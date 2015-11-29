<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\migrations;

class didyouknow_sample extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\didyouknow\migrations\didyouknow_schema',
		);
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'insert_sample_data'))),
		);
	}

	public function insert_sample_data()
	{
		global $user;

		// Define sample rule data
		$sample_data = array(
			array(
				'word_id' 			=> '1',
				'word' 				=> 'Testtext',
				'bbcode_uid' 		=> '',
				'bbcode_bitfield' 	=> '',
				'bbcode_options' 	=> '7',
				'lang_iso' 			=> 'default',
			),
		);

		// Insert sample PM data
		$this->db->sql_multi_insert($this->table_prefix . 'did_you_know', $sample_data);
	}
}
