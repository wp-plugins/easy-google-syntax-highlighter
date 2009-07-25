<?php
/*
Plugin Name: Easy Google Syntax Highlighter
Plugin URI: http://blog.burlock.org/easy-google-syntax-highlighter/
Description: This plugin is an implementation of the <a href='http://alexgorbatchev.com/wiki/SyntaxHighlighter'>Google Syntax Highlighter 2.0</a> with a front end to allow configuring all the global settings that are available.  Features include selecting themes and specifying languages to highlight.  Any language that is not selected will not be called by your blog which will improve page loading performance.
Version: 1.1.0
Author: Neil Burlock
Author URI: http://blog.burlock.org
*/

define('key_true', 'true', true);
define('key_false', 'false', true);

// Defaults, etc.
define('key_blogger_mode', 'easy_gsh_blogger_mode', true);
define('key_clipboard_swf', 'easy_gsh_clipboard_swf', true);
define('key_strip_brs', 'easy_gsh_strip_brs', true);
define('key_toolbar_item_width', 'easy_gsh_toolbar_item_width', true);
define('key_toolbar_item_height', 'easy_gsh_toolbar_item_height', true);
define('key_tag_name', 'easy_gsh_tag_name', true);
define('key_expand_source', 'easy_gsh_expand_source', true);
define('key_view_source', 'easy_gsh_view_source', true);
define('key_copy_to_clipboard', 'easy_gsh_copy_to_clipboard', true);
define('key_copy_to_clipboard_confirmation', 'easy_gsh_copy_to_clipboard_confirmation', true);
define('key_print', 'easy_gsh_print', true);
define('key_help', 'easy_gsh_help', true);
define('key_alert', 'easy_gsh_alert', true);
define('key_no_brush', 'easy_gsh_no_brush', true);
define('key_brush_not_html_script', 'easy_gsh_brush_not_html_script', true);
define('key_theme', 'easy_gsh_theme', true);
define('key_in_footer', 'easy_gsh_in_footer', true);
define('key_window_width', 'easy_gsh_window_width', true);
define('key_brushes', 'easy_gsh_brushes', true);
define('key_auto_brushes', 'auto_brushes', true);

define('blogger_mode_default', key_false, true);
define('clipboard_swf_default', key_true, true);
define('toolbar_item_width_default', '16', true);
define('toolbar_item_height_default', '16', true);
define('strip_brs_default', key_false, true);
define('tag_name_default', 'pre', true);
define('expand_source_default', '+ expand source', true);
define('view_source_default', 'view source', true);
define('copy_to_clipboard_default', 'copy to clipboard', true);
define('copy_to_clipboard_confirmation_default', 'The code is in your clipboard now', true);
define('print_default', 'print', true);
define('help_default', '?', true);
define('alert_default', mysql_real_escape_string('SyntaxHighlighter\n\n'), true);
define('no_brush_default', htmlspecialchars("Can't find brush for: ", ENT_QUOTES), true);
define('brush_not_html_script_default', htmlspecialchars("Brush wasn't made for html-script option: ", ENT_QUOTES), true);
define('theme_default', 'shThemeDefault.css', true);
define('in_footer_default', key_false, true);
define('window_width_default', '100%', true);
define('brushes_default', 'a:21:{i:0;s:13:"shBrushAS3.js";i:1;s:14:"shBrushBash.js";i:2;s:16:"shBrushCSharp.js";i:3;s:13:"shBrushCpp.js";i:4;s:13:"shBrushCss.js";i:5;s:16:"shBrushDelphi.js";i:6;s:14:"shBrushDiff.js";i:7;s:16:"shBrushGroovy.js";i:8;s:17:"shBrushJScript.js";i:9;s:14:"shBrushJava.js";i:10;s:16:"shBrushJavaFX.js";i:11;s:14:"shBrushPerl.js";i:12;s:13:"shBrushPhp.js";i:13;s:15:"shBrushPlain.js";i:14;s:20:"shBrushPowerShell.js";i:15;s:16:"shBrushPython.js";i:16;s:14:"shBrushRuby.js";i:17;s:15:"shBrushScala.js";i:18;s:13:"shBrushSql.js";i:19;s:12:"shBrushVb.js";i:20;s:13:"shBrushXml.js";}', true);
define('auto_brushes_default', key_false, true);

add_option(key_blogger_mode, blogger_mode_default, 'Blogger integration. If you are hosting on blogger.com, you must turn this on');
add_option(key_clipboard_swf, clipboard_swf_default, 'Facilitates clipboard functionality');
add_option(key_strip_brs, strip_brs_default, 'If your software adds &lt;br&gt; tags at the end of each line, this option allows you to ignore those. ');
add_option(key_toolbar_item_width, toolbar_item_width_default, 'Width of an icon in the toolbar. If you are customizing the toolbar and need to change width of the icons, you have to change toolbarItemWidth configuration property.');
add_option(key_toolbar_item_height, toolbar_item_height_default, 'Height of an icon in the toolbar.');
add_option(key_tag_name, tag_name_default, 'Facilitates using a different tag.');
add_option(key_expand_source, expand_source_default, '');
add_option(key_view_source, view_source_default, '');
add_option(key_copy_to_clipboard, copy_to_clipboard_default, '');
add_option(key_copy_to_clipboard_confirmation, copy_to_clipboard_confirmation_default, '');
add_option(key_print, print_default, '');
add_option(key_help, help_default, '');
add_option(key_alert, alert_default, '');
add_option(key_no_brush, no_brush_default, '');
add_option(key_brush_not_html_script, brush_not_html_script_default, '');
add_option(key_theme, theme_default, 'Select a theme for displaying the code');
add_option(key_in_footer, in_footer_default, 'Put the brush java in the footer to speed up loading.  May not be supported by all themes');
add_option(key_window_width, window_width_default, '');
add_option(key_brushes, brushes_default, '');
add_option(key_auto_brushes, auto_brushes_default, '');

add_action('admin_init', 'easy_admin_init');
function easy_admin_init() {
	if (function_exists('register_setting')) {
		register_setting('easy-google-syntax-highlighter', key_clipboard_swf, '');
		register_setting('easy-google-syntax-highlighter', key_strip_brs, '');
		register_setting('easy-google-syntax-highlighter', key_toolbar_item_width, '');
		register_setting('easy-google-syntax-highlighter', key_toolbar_item_height, '');
		register_setting('easy-google-syntax-highlighter', key_tag_name, '');
		register_setting('easy-google-syntax-highlighter', key_expand_source, '');
		register_setting('easy-google-syntax-highlighter', key_view_source, '');
		register_setting('easy-google-syntax-highlighter', key_copy_to_clipboard, '');
		register_setting('easy-google-syntax-highlighter', key_copy_to_clipboard_confirmation, '');
		register_setting('easy-google-syntax-highlighter', key_print, '');
		register_setting('easy-google-syntax-highlighter', key_help, '');
		register_setting('easy-google-syntax-highlighter', key_alert, '');
		register_setting('easy-google-syntax-highlighter', key_no_brush, '');
		register_setting('easy-google-syntax-highlighter', key_brush_not_html_script, '');
		register_setting('easy-google-syntax-highlighter', key_theme, '');
		register_setting('easy-google-syntax-highlighter', key_in_footer, '');
		register_setting('easy-google-syntax-highlighter', key_window_width, '');
		register_setting('easy-google-syntax-highlighter', key_brushes, '');
		register_setting('easy-google-syntax-highlighter', key_blogger_mode, '');
		register_setting('easy-google-syntax-highlighter', key_auto_brushes, '');
	}
}

function edit_boolean($key) {
	echo "<select name='$key' id='$key'>";
	echo "<option value='".key_true."'";
	if (get_option($key) == key_true)
		echo " selected='selected'";
	echo ">&nbsp;On&nbsp;</option>";
	echo "<option value='".key_false."'";
	if (get_option($key) == key_false)
		echo " selected='selected'";
	echo ">&nbsp;Off&nbsp;</option>";
	echo "</select>";
}

function edit_text($key, $size = 25) {
	echo "<input type='text' size='$size' name='$key' id='$key' value='".stripslashes(get_option($key))."' />";
}

function edit_int($key, $size = 10) {
	echo "<input type='text' size='$size' name='$key' id='$key' value='".stripslashes(get_option($key))."' />";
}

// Retrieve the installed themes (shTheme*.css) and retun them as a select list
function edit_themes($key) {	
	echo "<select name='$key' id='$key'>";
	$files = array_diff(scandir(dirname(__FILE__)."/styles/"), array('.', '..'));

	// Only looking for shTheme*.css
	foreach ($files as $file) {
		if (eregi("shTheme.*.\.css$", $file)) {
			echo "<option value='$file'";
			if (get_option($key) == $file) 
				echo " selected='selected'";
			echo ">".str_replace('shTheme', '', str_replace('.css', '', $file))."</option>";
		}
	}
	echo "</select>";
}

// Retrieve a list of available brushes and return them as an array of boolean select boxes
function edit_brushes($key) {
	$brushes = unserialize(get_option($key));
	
	$raw_files = array_diff(scandir(dirname(__FILE__)."/scripts/"), array('.', '..', 'shCore.js'));
	
	// Only looking for shBrush*.js
	// Remove any other non brush files from the array
	$files = array();
	foreach ($raw_files as $file) {
		if (eregi("shBrush.*.\.js$", $file))		
			array_push($files, $file);
	}
	
	// Arrange the results in 5 columns
	$cols = 5;
	$rows = ceil(sizeof($files) / $cols);
	echo "<input type='hidden' name='brush_files' value='".serialize($files)."'/>";
	echo "<tr><td colspan=3><table>";
	for ($row = 0; $row < $rows; $row++) {
		echo "<tr>";
		for ($col = 0; $col < $cols; $col++) {
			$cell = ($row * $cols) + $col;
			if ($cell < sizeof($files)) {
				echo "<td>".str_replace('shBrush', '', str_replace('.js', '', $files[$cell]))."</td><td><select name='".str_replace('.', '_', $files[$cell])."' id='".str_replace('.', '_', $files[$cell])."'>";
				echo "<option value='".key_true."'";
				if (in_array($files[$cell], $brushes))
					echo " selected='selected'";
				echo ">&nbsp;On&nbsp;</option>";
				echo "<option value='".key_false."'";
				if (!in_array($files[$cell], $brushes))
					echo " selected='selected'";
				echo ">&nbsp;Off&nbsp;</option>";
				echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			} else {
				echo "<td></td>";
			}
		}	
		echo "</tr>";	
	}
	echo "</table></td></tr>";
}

function encode_str($s) {
	return mysql_real_escape_string(htmlspecialchars(stripslashes($s), ENT_QUOTES));
}

function decode_str($s) {
	return htmlspecialchars_decode($s, ENT_QUOTES);
}

add_action('admin_menu', 'add_easy_gsh_options_page');
function add_easy_gsh_options_page() {
	add_options_page('Easy Google Syntax Highlighter Settings', 'Easy Syn Highlight', 8, basename(__FILE__), 'easy_gsh_options_page');
}

function easy_gsh_options_page() {
	if (isset($_POST['info_update'])) {
		// Save the options

		// blogger_mode: bool
		//$value = $_POST[key_blogger_mode];
		//if (($value != key_true) && ($value != key_false))
		//	$value = blogger_mode_default;
		//update_option(key_blogger_mode, $value);

		// clipboard_swf: bool
		$value = $_POST[key_clipboard_swf];
		if (($value != key_true) && ($value != key_false))
			$value = clipboard_swf_default;
		update_option(key_clipboard_swf, $value);

		// toolbar_item_width: int
		$value = $_POST[key_toolbar_item_width];
		if (($value == '') or !is_numeric($value))
			$value = toolbar_item_width_default;
		update_option(key_toolbar_item_width, $value);

		// toolbar_item_height: int
		$value = $_POST[key_toolbar_item_height];
		if (($value == '') or !is_numeric($value))
			$value = toolbar_item_height_default;
		update_option(key_toolbar_item_height, $value);

		// strip_brs: bool
		$value = $_POST[key_strip_brs];
		if (($value != key_true) && ($value != key_false))
			$value = strip_brs_default;
		update_option(key_strip_brs, $value);

		// tag_name: str
		$value = $_POST[key_tag_name];
		if ($value == '') $value = tag_name_default;
		else $value = encode_str($value);		
		update_option(key_tag_name, $value);

		// expand_source: str
		$value = $_POST[key_expand_source];
		if ($value == '') $value = expand_source_default;
		else $value = encode_str($value);		
		update_option(key_expand_source, $value);

		// view_source: str
		$value = $_POST[key_view_source];
		if ($value == '') $value = view_source_default;
		else $value = encode_str($value);
		update_option(key_view_source, $value);

		// copy_to_clipboard: str
		$value = $_POST[key_copy_to_clipboard];
		if ($value == '') $value = copy_to_clipboard_default;
		else $value = encode_str($value);		
		update_option(key_copy_to_clipboard, $value);

		// copy_to_clipboard_confirmation: str
		$value = $_POST[key_copy_to_clipboard_confirmation];
		if ($value == '') $value = copy_to_clipboard_confirmation_default;
		else $value = encode_str($value);		
		update_option(key_copy_to_clipboard_confirmation, $value);

		// print: str
		$value = $_POST[key_print];
		if ($value == '') $value = print_default; 
		else $value = encode_str($value);
		update_option(key_print, $value);

		// help: str
		$value = $_POST[key_help];
		if ($value == '') $value = help_default;
		else $value = encode_str($value);
		update_option(key_help, $value);

		// alert: str
		$value = $_POST[key_alert];
		if ($value == '') $value = alert_default;
		else $value = encode_str($value);
		update_option(key_alert, $value);

		// no_brush: str
		$value = $_POST[key_no_brush];
		if ($value == '') $value = no_brush_default;
		else $value = encode_str($value);
		update_option(key_no_brush, $value);

		// brush_not_html_script: str
		$value = $_POST[key_brush_not_html_script];
		if ($value == '') $value = brush_not_html_script_default;
		else $value = encode_str($value);
		update_option(key_brush_not_html_script, $value);

		// theme: str
		$value = $_POST[key_theme];
		if ($value == '') $value = theme_default;
		else $value = encode_str($value);
		update_option(key_theme, $value);

		// in_footer: bool
		$value = $_POST[key_in_footer];
		if (($value != key_true) && ($value != key_false))
			$value = in_footer_default;
		update_option(key_in_footer, $value);

		// auto_brushes: bool
		$value = $_POST[key_auto_brushes];
		if (($value != key_true) && ($value != key_false))
			$value = auto_brushes_default;
		update_option(key_auto_brushes, $value);

		// window_width: str
		$value = $_POST[key_window_width];
		if ($value == '') $value = window_width_default;
		else $value = encode_str($value);
		update_option(key_window_width, $value);

		// brushes: str
		$brushes = array();
		$brush_files = unserialize(stripslashes($_POST["brush_files"]));
		foreach ($brush_files as $brush) {
			if ($_POST[str_replace('.', '_', $brush)] == key_true)
				array_push($brushes, $brush);
		}
		if (sizeof($brushes) == 0) $value = brushes_default;
		else $value = serialize($brushes);
		update_option(key_brushes, $value);

		// Saved message
		echo "<div class='updated fade'><p><strong>Easy Google Syntax Highlighter settings saved.</strong></p></div>";

	} else if (isset($_POST['info_reset'])) {
		
		// Reset to defaults
		update_option(key_blogger_mode, blogger_mode_default);
		update_option(key_clipboard_swf, clipboard_swf_default);
		update_option(key_toolbar_item_width, toolbar_item_width_default);
		update_option(key_toolbar_item_height, toolbar_item_height_default);
		update_option(key_strip_brs, strip_brs_default);
		update_option(key_tag_name, tag_name_default);
		update_option(key_expand_source, expand_source_default);
		update_option(key_view_source, view_source_default);
		update_option(key_copy_to_clipboard, copy_to_clipboard_default);
		update_option(key_copy_to_clipboard_confirmation, copy_to_clipboard_confirmation_default);
		update_option(key_print, print_default);
		update_option(key_help, help_default);
		update_option(key_alert, alert_default);
		update_option(key_no_brush, no_brush_default);
		update_option(key_brush_not_html_script, brush_not_html_script_default);
		update_option(key_theme, theme_default);
		update_option(key_in_footer, in_footer_default);
		update_option(key_window_width, window_width_default);
		update_option(key_brushes, brushes_default);

		echo "<div class='updated fade'><p><strong>Easy Google Syntax Highlighter settings reset to defaults.</strong></p></div>";
	}

	// Output options page
	?>
		<div class="wrap">

		<h2>Easy Google Syntax Highlighter</h2>
			
		<form method="post" action="options-general.php?page=easy-google-syntax-highlighter.php">
			
			<em>WordPress plugin written by <a href="http://blog.burlock.org/easy-google-syntax-highlighter/">Neil Burlock</a> using Alex Gorbatchev's <a href="http://alexgorbatchev.com/wiki/SyntaxHighlighter">Syntax Highlighter 2.0</a></em>

		  	<table width='100%' cellspacing='2' cellpadding='5' class='editform'>
				<tr><td><h3>General settings</h3></td><td></td><td></td></tr>
		      	<tr>
					<td>Clipboard SWF</td>
					<td><?php edit_boolean(key_clipboard_swf) ?></td>
					<td>Controls whether the "copy to clipboard" icon is showing</td>
				</tr>
		      	<tr>
					<td>Strip &lt;br&gt;</td>
					<td><?php edit_boolean(key_strip_brs) ?></td>
					<td>This option will ignore any &lt;br&gt; tags added to the end of each line in the code snippet</td>
				</tr>
		      	<tr>
					<td>Toolbar Item Width</td>
					<td><?php edit_int(key_toolbar_item_width) ?></td>
					<td>Toolbar icon width.  This should only be used if you are changing the icon images.</td>
				</tr>
		      	<tr>
					<td>Toolbar Item Height</td>
					<td><?php edit_int(key_toolbar_item_height) ?></td>
					<td>Toolbar icon height.  This should only be used if you are changing the icon images.</td>
				</tr>
		      	<tr>
					<td>Tag Name</td>
					<td><?php edit_text(key_tag_name) ?></td>
					<td>HTML Tag to use when marking a code snippet.</td>
				</tr>
		      	<tr>
					<td>Theme</td>
					<td><?php edit_themes(key_theme) ?></td>
					<td>Sets the appearance of the code window</td>
				</tr>
				<tr><td colspan=3><h3>Enabled Brushes</h3></td></tr>
				<?php edit_brushes(key_brushes) ?>
				<tr><td colspan=3><h3>Custom Settings</h3></td></tr>			
		      	<tr>
					<td>Auto Brushes</td>
					<td><?php edit_boolean(key_auto_brushes) ?></td>
					<td>When On, brushes will be automatically selected based on the body of the page being displayed, for maximum loading performance.</td>
				</tr>
		      	<tr>
					<td>Brushes In Footer</td>
					<td><?php edit_boolean(key_in_footer) ?></td>
					<td>When On, brushes are loaded in the footer, improving performance.  Only for themes with a footer.</td>
				</tr>
				<tr><td colspan=3><h3>Strings</h3></td></tr>
		      	<tr>
					<td>Expand Source</td>
					<td><?php edit_text(key_expand_source) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>View Source</td>
					<td><?php edit_text(key_view_source) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Copy to Clipboard</td>
					<td><?php edit_text(key_copy_to_clipboard) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Copy Confirmation</td>
					<td><?php edit_text(key_copy_to_clipboard_confirmation) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Print</td>
					<td><?php edit_text(key_print) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Help</td>
					<td><?php edit_text(key_help) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Alert</td>
					<td><?php edit_text(key_alert) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>No Brush</td>
					<td><?php edit_text(key_no_brush) ?></td>
					<td></td>
				</tr>
		      	<tr>
					<td>Brush Not Html</td>
					<td><?php edit_text(key_brush_not_html_script) ?></td>
					<td></td>
				</tr>
			</table>
			<p class="submit">
				<?php if (function_exists('settings_fields')) settings_fields('easy-google-syntax-highlighter'); ?>
				<input type="submit" name="info_update" value="<?php _e('Save Settings', 'easy-google-syntax-highlighter'); ?>" />
				<input type="submit" name="info_reset" value="<?php _e('Reset Settings', 'easy-google-syntax-highlighter'); ?>" onClick="return confirm('Are you sure you reset all settings to defaults?')" />
			</p>
		</div>
		</form>
<?php
}

add_action('wp_head','easy_gsh_insert_core');
function easy_gsh_insert_core() {
	$theme = get_option(key_theme);
	$path = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__));
	echo "<link href='$path/styles/shCore.css' type='text/css' rel='stylesheet' />";

	// key_theme
	echo "<link href='$path/styles/$theme' type='text/css' rel='stylesheet' id='shTheme'/>";
}

// key_auto_brushes
if (get_option(key_auto_brushes) == key_true)
	add_filter('the_content', 'easy_gsh_scan_for_brushes', 9);

// If requested, scan the body of the document for references to brushes that are required and generate the SQL required to include them
function easy_gsh_scan_for_brushes($content) {
	$selected = array();
	global $easy_gsh_selected;
	if ($easy_gsh_selected != '')
		$selected = unserialize($easy_gsh_selected);
	
	$path = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__));
	
	// Generate a regex tag - /i isn't working for on my testing box for some reason, so do it the hard way
	$tag = '';
	$array = preg_split('//', get_option(key_tag_name), -1, PREG_SPLIT_NO_EMPTY);
	foreach ($array as $char) {
		$tag .= '['.strtolower($char).strtoupper($char).']';
	}
	$tag = 'pre';

	// Fetch the key_tag_name tags in the body
	if (preg_match_all('/<'.$tag.'.+?>/', $content, $matches) > 0) {
				// Got the brush, translate it into the equivalent js file
				$brushes = array('shBrushAS3.js' => array('as3', 'actionscript3'),
								 'shBrushBash.js' => array('bash', 'shell'),
								 'shBrushCSharp.js' => array('c-sharp', 'csharp'),
								 'shBrushCpp.js' => array('cpp', 'c'),
								 'shBrushCss.js' => array('css'),
								 'shBrushDelphi.js' => array('delphi', 'pas', 'pascal'),
								 'shBrushDiff.js' => array('diff', 'patch'),
								 'shBrushGroovy.js' => array('groovy'),
								 'shBrushJScript.js' => array('js', 'jscript', 'javascript'),
								 'shBrushJava.js' => array('java'),
								 'shBrushJavaFX.js' => array('jfx', 'javafx'),
								 'shBrushPerl.js' => array('perl', 'pl'),
								 'shBrushPhp.js' => array('php'),
								 'shBrushPlain.js' => array('plain', 'text'),
								 'shBrushPowerShell.js' => array('ps', 'powershell'),
								 'shBrushPython.js' => array('py', 'python'),
								 'shBrushRuby.js' => array('rails', 'ror', 'ruby'),
								 'shBrushScala.js' => array('scala'),
								 'shBrushSql.js' => array('sql'),
								 'shBrushVb.js' => array('vb', 'vbnet'),
							 	 'shBrushXml.js' => array('xml', 'xhtml', 'xslt', 'html', 'xhtml'));
				$files = array_keys($brushes);
		
		// For each tag, extract the class clause, assuming it is like "brush: brushname"
		foreach ($matches[0] as $match) {
			if (preg_match_all('/brush *: *[a-zA-Z0-9_\.]*/', $match, $brush) == 1) {
				$brush = explode(":", $brush[0][0]);
				$brush = strtolower(trim($brush[1]));
				foreach ($files as $file) {
					if (in_array($brush, $brushes[$file])) {
						if (!in_array($file, $selected)) {
							array_push($selected, $file);
							break;
						}
					}
				}
			}
		}
	}
		
	// Save the selected brushes list
	$easy_gsh_selected = serialize($selected);

	return $content;
}

// key_in_footer
if (get_option(key_in_footer) == key_true) add_action('wp_footer','easy_gsh_insert_brushes');
else add_action('wp_head','easy_gsh_insert_brushes');

function easy_gsh_insert_brushes() {
	$path = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__));

	// key_auto_brushes
	if (get_option(key_auto_brushes) == key_false) {
		// key_brushes
		echo "<script class='javascript' src='$path/scripts/shCore.js'></script>\n";
		$brushes = unserialize(get_option(key_brushes));
		foreach ($brushes as $brush) {
			echo "<script class='javascript' src='$path/scripts/$brush'></script>\n";
		}
		echo easy_gsh_insert_jscript();
	} else {
		// Show only brushes found on the page.  If nothing is found, then don't add any javascript at all
		global $easy_gsh_selected;
		$selected = unserialize($easy_gsh_selected);
		if (sizeof($selected) > 0) {
			$included_js = "";
			echo "<script type='text/javascript' src='$path/scripts/shCore.js'></script>\n";
			foreach ($selected as $file) {
				echo "<script type='text/javascript' src='$path/scripts/$file'></script>\n";
			}
			echo easy_gsh_insert_jscript();
		}
	}
}

// Returns the script necessary to set the admin's options
function easy_gsh_insert_jscript() {
	$script = "<script type='text/javascript'>\n";

	// key_blogger_mode
	if (get_option(key_blogger_mode) != blogger_mode_default)
		$script .= "SyntaxHighlighter.config.bloggerMode = ".get_option(key_strip_brs).";\n";

	// key_toolbar_item_width
	if (get_option(key_toolbar_item_width) <> toolbar_item_width_default)
		$script .=  "SyntaxHighlighter.config.toolbarItemWidth = ".get_option(key_toolbar_item_width).";\n";
	
	// key toolbar_item_height
	if (get_option(key_toolbar_item_height) <> toolbar_item_height_default)
		$script .=  "SyntaxHighlighter.config.toolbarItemHeight = ".get_option(key_toolbar_item_height).";\n";

	// key_strip_brs
	if (get_option(key_strip_brs) != strip_brs_default)
		$script .=  "SyntaxHighlighter.config.stripBrs = ".get_option(key_strip_brs).";\n";

	// key_tag_name
	if (get_option(key_tag_name) != tag_name_default)
		$script .=  "SyntaxHighlighter.config.tagName = ".get_option(key_tag_name).";\n";

	// key_expand_source
	if (get_option(key_expand_source) != expand_source_default)
		$script .=  "SyntaxHighlighter.config.strings.expandSource = '".get_option(key_expand_source)."';\n";

	// key_view_source
	if (get_option(key_view_source) != view_source_default)
		$script .=  "SyntaxHighlighter.config.strings.viewSource = '".get_option(key_view_source)."';\n";

	// key_copy_to_clipboard
	if (get_option(key_copy_to_clipboard) != copy_to_clipboard_default)
		$script .=  "SyntaxHighlighter.config.strings.copyToClipboard = '".get_option(key_copy_to_clipboard)."';\n";

	// key_copy_to_clipboard_confirmation
	if (get_option(key_copy_to_clipboard_confirmation) != copy_to_clipboard_confirmation_default)
		$script .=  "SyntaxHighlighter.config.strings.copyToClipboardConfirmation = '".get_option(key_copy_to_clipboard_confirmation)."';\n";

	// key_print
	if (get_option(key_print) != print_default)
		$script .=  "SyntaxHighlighter.config.strings.print = '".get_option(key_print)."';\n";

	// key_help
	if (get_option(key_help) != help_default)
		$script .=  "SyntaxHighlighter.config.strings.help = '".get_option(key_help)."';\n";

	// key_alert
	if (get_option(key_alert) != alert_default)
		$script .=  "SyntaxHighlighter.config.strings.alert = '".get_option(key_alert)."';\n";

	// key_no_brush
	if (get_option(key_no_brush) != no_brush_default)
		$script .=  "SyntaxHighlighter.config.strings.noBrush = '".get_option(key_no_brush)."';\n";

	// key_brush_not_html_script
	if (get_option(key_brush_not_html_script) != brush_not_html_script_default)
		$script .=  "SyntaxHighlighter.config.strings.brushNotHtmlScript = '".get_option(key_brush_not_html_script)."';\n";		

	// key_clipboard_swf
	// if (get_option(key_clipboard_swf) == key_true) $script .=  "SyntaxHighlighter.config.clipboardSwf = '$path/scripts/clipboard.swf';\n";
	if (get_option(key_clipboard_swf) == key_true) $script .=  "SyntaxHighlighter.config.clipboardSwf = 'http://blog.burlock.org/wp-content/plugins/easy-google-syntax-highlighter/scripts/clipboard.swf';\n";
	$script .=  "SyntaxHighlighter.all();</script>\n";
	return $script;
}

?>
