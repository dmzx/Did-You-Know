<?php
/**
*
* @package phpBB Extension - Did You Know
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_DYK_EDIT_WORD'				=> 'Edit Did-You-Know',
	'ACP_DYK_ENTER_WORD'			=> 'You have to insert a text!',
	'ACP_DYK_EXPLAIN'				=> 'Here you can insert, edit or delete the Did-You-Know texts. These texts will then appear in a random order on the viewforum page.',
	'ACP_DYK_EXPLAIN_EDIT'			=> 'Here you can insert or edit Did-You-Know texts.',
	'ACP_DYK_FORM_INVALID'			=> 'The submitted text was invalid. Try submitting again.',
	'ACP_DYK_NEW_WORD'				=> 'Add new text',
	'ACP_DYK_NO_WORD'				=> 'No text selected for editing!',
	'ACP_DYK_TITLE'					=> 'Did-You-Know administration',
	'ACP_DYK_WORD'					=> 'Text',
	'ACP_DYK_WORD_ADDED'			=> 'The text has been successfully added.',
	'ACP_DYK_WORD_EDIT'				=> 'Edit or insert the text here',
	'ACP_DYK_WORD_ID'				=> 'Id',
	'ACP_DYK_WORD_REMOVED'			=> 'The selected text has been successfully removed.',
	'ACP_DYK_WORD_UPDATED'			=> 'The selected text has been successfully updated.',
	'ACP_DYK_REMOVE_TABLES'			=> 'Did you know table successfully removed',
	'ACP_DYK_INSERT_FIRST_FILL'		=> 'Did-You-Know table filled with basic values',
	'ACP_DYK_UPDATE'				=> 'Did you know Module successfully updated',
	'ADD_DYK'						=> 'Add new entry',
	'EDIT_DYK'						=> 'Edit entry',
	'LANGUAGE_SET'					=> 'Language package',
	'LANGUAGE_SET_DEFAULT'			=> 'Independent',
	'LANGUAGE_SET_EXPLAIN'			=> 'Set here the language in which the text should be shown to the users.',
	'LANGUAGE_SET_SETTINGS'			=> 'Language package settings',
	'LOG_DYK_DELETE'				=> '<strong>"Did-You-Know?" text no. %s was deleted</strong>',
	'LOG_DYK_SAVE'					=> '"Did-You-Know?" text no. %s was edited',
	'LOG_DYK_SAVE_NEW'				=> 'A new "Did-You-Know" text was added',

	// Permission
	'ACL_U_DID_YOU_KNOW'			=> 'Can manage "Did-You-Know?" texts',
));
