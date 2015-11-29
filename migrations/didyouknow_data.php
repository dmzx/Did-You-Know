<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\migrations;

class didyouknow_data extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(

			// Add permissions
			array('permission.add', array('u_did_you_know', true)),

			// Set permissions
			array('permission.permission_set', array('REGISTERED', 'u_did_you_know', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_did_you_know', 'group')),
		);
	}
}
