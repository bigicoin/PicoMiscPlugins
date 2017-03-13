<?php

/**
 * Enable Share Buttons powered by jiathis.com on some pages, based on meta data.
 * Allow custom placement of jiathis module in theme file.
 *
 * On pages:
 * Put this header in your markdown file's meta header section, for pages you want jiathis on:
 * Share-Buttons: 1
 *
 * On themes:
 * Include this variable in your theme html or twig file, wherever you want the jiathis module to appear:
 * {{ share_buttons }}
 *
 * @author  Bigi Lui
 * @link    https://github.com/bigicoin/PicoMiscPlugins
 * @license MIT
 */

final class PicoShareButtons extends AbstractPicoPlugin
{
	/**
	 * This plugin is enabled by default?
	 *
	 * @see AbstractPicoPlugin::$enabled
	 * @var boolean
	 */
	protected $enabled = false;

	/**
	 * This plugin depends on ...
	 *
	 * @see AbstractPicoPlugin::$dependsOn
	 * @var string[]
	 */
	protected $dependsOn = array();

	protected $isShareButtonsOn = false;

	/**
	 * Triggered when Pico reads its known meta header fields
	 *
	 * @see    Pico::getMetaHeaders()
	 * @param  string[] &$headers list of known meta header
	 *     fields; the array value specifies the YAML key to search for, the
	 *     array key is later used to access the found value
	 * @return void
	 */
	public function onMetaHeaders(array &$headers)
	{
		// your code
		$headers['sharebuttons'] = 'Share-Buttons';
	}

	/**
	* Triggered after Pico has parsed the meta header
	*
	* @see    Pico::getFileMeta()
	* @param  string[] &$meta parsed meta data
	* @return void
	*/
	public function onMetaParsed(array &$meta)
	{
		$this->isShareButtonsOn = !empty($meta['sharebuttons']);
	}

	/**
	 * Triggered before page rendering
	 */
	public function onPageRendering(Twig_Environment &$twig, array &$twigVariables, &$templateName) {
		// put in comment form by filling fb_comment twig variable
		if ($this->isShareButtonsOn) {
			$twigVariables['share_buttons'] = <<<'EOD'
<a href="http://www.jiathis.com/share/" class="jiathis" target="_blank"><img src="http://v2.jiathis.com/code/images/jiathis2.gif" border="0" id="jiathis_a" /></a>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
EOD;
		} else {
			$twigVariables['share_buttons'] = '';
		}
	}
}
