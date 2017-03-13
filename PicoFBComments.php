<?php

/**
 * Enable FB Comments on some posts, based on meta data.
 * Allow custom placement of comments module in theme file.
 *
 * On pages:
 * Put this header in your markdown file's meta header section, for pages you want comments on:
 * FB-Comments: 1
 *
 * On themes:
 * Include this variable in your theme html or twig file, wherever you want the comments module to appear:
 * {{ fb_comments }}
 * 
 * @author Bigi Lui
 * @link    https://github.com/bigicoin/PicoMiscPlugins
 * @license MIT
 */

final class PicoFBComments extends AbstractPicoPlugin
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

	protected $baseUrl = '';
	protected $requestUrl = '';
	protected $isFBCommentsOn = false;

	/**
	 * Triggered after Pico has read its configuration
	 *
	 * @see    Pico::getConfig()
	 * @param  array &$config array of config variables
	 * @return void
	 */
	public function onConfigLoaded(array &$config)
	{
		// cache some values from config
		$this->baseUrl = $config['base_url'];
		// figure out if baseUrl has a space at the end
		if (substr($this->baseUrl, strlen($this->baseUrl)-1) != '/') {
			// add it in
			$this->baseUrl .= '/';
		}
	}
	
	/**
	 * Triggered after Pico has evaluated the request URL
	 *
	 * @see    Pico::getRequestUrl()
	 * @param  string &$url part of the URL describing the requested contents
	 * @return void
	 */
	public function onRequestUrl(&$url)
	{
		// cache some values
		$this->requestUrl = $url;
	}

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
		$headers['fbcomments'] = 'FB-Comments';
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
		$this->isFBCommentsOn = !empty($meta['fbcomments']);
	}

	/**
	 * Triggered after Pico has rendered the page
	 *
	 * @param  string &$output contents which will be sent to the user
	 * @return void
	 */
	public function onPageRendered(&$output)
	{
		if ($this->isFBCommentsOn) {
			$output = str_replace('</body>', ($this->buildExtraHeaders() . "\n</body>"), $output);
		}
	}

	/**
	 * Add some extra header tags to regular html pages for AMP and IA info.
	 */
	private function buildExtraHeaders() {
		$headers = <<<'EOD'
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
EOD;
		return $headers;
	}

	/**
	 * Triggered before page rendering
	 */
	public function onPageRendering(Twig_Environment &$twig, array &$twigVariables, &$templateName) {
		// put in comment form by filling fb_comment twig variable
		if ($this->isFBCommentsOn) {
			$twigVariables['fb_comments'] = '<div class="fb-comments" data-href="'.$this->baseUrl.$this->requestUrl.'" data-width="100%" data-numposts="10"></div>';
		} else {
			$twigVariables['fb_comments'] = '';
		}
	}
}
