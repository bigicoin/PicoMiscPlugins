<?php

/**
 * Pico Old Links Redirect
 *
 * Catch 404 events, and check requested url against a list, see if it should be redirected.
 * Usage: Create a redirectList.php file, place it in your root Pico directory.
 * In that file, include an associative array $redirects.
 * Keys should be old URLs, values should be new URLs. Example:
 * $redirects = array(
 *   'old/url/one' => 'new/url/one',
 *   'old/url/two' => 'new/url/two'
 * );
 *
 * @author  Bigi Lui
 * @link    https://github.com/bigicoin/PicoMiscPlugins
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
final class PicoOldLinksRedirect extends AbstractPicoPlugin
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

	protected $contentDir = '';
	protected $contentExt = '';

	/**
	 * Triggered after Pico has read its configuration
	 *
	 * @see    Pico::getConfig()
	 * @param  array &$config array of config variables
	 * @return void
	 */
	public function onConfigLoaded(array &$config)
	{
		$this->contentDir = $config['content_dir'];
		$this->contentExt = $config['content_ext'];
	}

	/**
	 * Triggered before Pico reads the contents of a 404 file
	 *
	 * @see    Pico::load404Content()
	 * @see    DummyPlugin::on404ContentLoaded()
	 * @param  string &$file path to the file which contents were requested
	 * @return void
	 */
	public function on404ContentLoading(&$file)
	{
		$realFile = $file; // just in case we accidentally modify the variable
		if (strpos($realFile, $this->contentDir) === 0) {
			$realFile = substr($realFile, strlen($this->contentDir));
		}
		if (strrpos($realFile, $this->contentExt) == strlen($realFile) - strlen($this->contentExt)) {
			$realFile = substr($realFile, 0, strlen($realFile) - strlen($this->contentExt));
		}
		// grab the big redirect list
		@include($this->contentDir.'/../redirectList.php');
		if (!empty($redirects) && !empty($redirects[$realFile])) {
			// shoulld redirect
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /".$redirects[$realFile]); 
			exit;
		}
	}
}
