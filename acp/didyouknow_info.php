<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\didyouknow\acp;

class didyouknow_info
{
	function module()
	{
		return array(
			'filename'		=> '\dmzx\didyouknow\acp\didyouknow_module',
			'title'			=> 'DYK_TITLE',
			'modes'			=> array(
				'did_you_know'		=> array('title' => 'DYK_TITLE', 'auth'	=> 'ext_dmzx/didyouknow && acl_a_board', 'cat'	=> array('DYK_TITLE'),
				),
			),
		);
	}
}
