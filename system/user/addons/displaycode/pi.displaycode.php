<?php
/*
=====================================================
Colorizes code with the Typography class.
-----------------------------------------------------
v0.1: Escape values.
=====================================================
*/

if (!defined('BASEPATH')) {
	exit('No direct script access allowed.');
}

$plugin_info = array(
	'pi_name' => 'Display Code',
	'pi_version' => '0.2',
	'pi_author' => 'EpicVoyage',
	'pi_author_url' => 'http://www.epicvoyage.org/ee/code',
	'pi_description' => 'Colorizes code with the typography class.',
	'pi_usage' => Displaycode::usage()
);

class Displaycode {
	var $return_data = '';

	function __construct() {
		ee()->load->library('typography');
		ee()->typography->initialize();

		if (ee()->TMPL->fetch_param('add_tags', 'yes') != 'no') {
			ee()->TMPL->tagdata = html_entity_decode(ee()->TMPL->tagdata); //str_replace('&amp;', '&', $this->return_data);
			ee()->TMPL->tagdata = preg_replace('/^<pre>(.*)<\/pre>$/ms', '$1', ee()->TMPL->tagdata);
			ee()->TMPL->tagdata = '[code]'.ee()->TMPL->tagdata.'[/code]';
		}

		$this->return_data = ee()->typography->text_highlight(ee()->TMPL->tagdata);

		if (count(ee()->typography->code_chunks) > 0) {
			foreach (ee()->typography->code_chunks as $key => $val) {
				$this->return_data = str_replace('[div class="codeblock"]{'.$key.'yH45k02wsSdrp}[/div]', '<div class="codeblock">'.$val.'</div>', $this->return_data);
			}
		}

		return;
	}

	static function usage() {
		return <<<EOF
Colorizes code with the Typography class.

{exp:code}
{my_code}
{/exp:code}

{exp:code add_tags="no"}
Do not automatically add [code] blocks (for the Typography class) to this area.
{something_with_code_in_it}
{/exp:code}
EOF;
	}
}
