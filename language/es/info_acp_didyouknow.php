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
	'ACP_DYK_EDIT_WORD'				=> 'Editar Sabías Que...',
	'ACP_DYK_ENTER_WORD'			=> '¡Tiene que insertar un texto!',
	'ACP_DYK_EXPLAIN'				=> 'Aquí puede insertar, editar o borrar los texto de Sabías Que... Estos textos aparecerán en orden aleatorio en la página viendo un foro.',
	'ACP_DYK_EXPLAIN_EDIT'			=> 'Aquí puede insertar o editar los textos de Sabías Que...',
	'ACP_DYK_FORM_INVALID'			=> 'El texto presentado no es válido. Intente enviarlo de nuevo.',
	'ACP_DYK_NEW_WORD'				=> 'Añadir nuevo texto',
	'ACP_DYK_NO_WORD'				=> '¡No hay texto seleccionado para editar!',
	'ACP_DYK_TITLE'					=> 'Administración de Sabías Que...',
	'ACP_DYK_WORD'					=> 'Texto',
	'ACP_DYK_WORD_ADDED'			=> 'El texto ha sido añadido correctamente.',
	'ACP_DYK_WORD_EDIT'				=> 'Editar o insertar el texto aquí',
	'ACP_DYK_WORD_ID'				=> 'Id',
	'ACP_DYK_WORD_REMOVED'			=> 'El texto seleccionado ha sido eliminado correctamente.',
	'ACP_DYK_WORD_UPDATED'			=> 'El texto seleccionado ha sido editado correctamente.',
	'ACP_DYK_REMOVE_TABLES'			=> 'Tabla de Sabías Que... eliminada correctamente.',
	'ACP_DYK_INSERT_FIRST_FILL'		=> 'Tabla de Sabías Que... esta llena de valores básicos',
	'ACP_DYK_UPDATE'				=> 'Módulo de Sabías Que... actualizado correctamente.',
	'ADD_DYK'						=> 'Añadir nueva entrada',
	'EDIT_DYK'						=> 'Editar entrada',
	'LANGUAGE_SET'					=> 'Paquete de idioma',
	'LANGUAGE_SET_DEFAULT'			=> 'Independiente',
	'LANGUAGE_SET_EXPLAIN'			=> 'Establezca aquí el idioma en que el texto se debe mostrar a los usuarios.',
	'LANGUAGE_SET_SETTINGS'			=> 'Ajustes del paquete de idioma',
	'LOG_DYK_DELETE'				=> '<strong>Texto no. %s de “¿Sabías que...?” ha sido borrado</strong>',
	'LOG_DYK_SAVE'					=> 'Texto no. %s de “¿Sabías que...?” ha sido editado',
	'LOG_DYK_SAVE_NEW'				=> 'Un nuevo texto de “¿Sabías que...?” ha sido añadido',

	// Permission
	'ACL_U_DID_YOU_KNOW'			=> 'Puede gestionar textos de “¿Sabías que...?”',
));
