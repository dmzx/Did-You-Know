<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\migrations;

class didyouknow_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'DYK_TITLE')),
			array('module.add', array(
			'acp', 'DYK_TITLE', array(
					'module_basename'	=> '\dmzx\didyouknow\acp\didyouknow_module', 'modes'	=>	array('did_you_know'),
				),
			)),
		);
	}
}
