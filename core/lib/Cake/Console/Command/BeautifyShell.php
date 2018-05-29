<?php
/* SVN FILE: $Id: beautify.php 182 2009-02-10 14:04:41Z rajesh_04ag02 $ */
/**
 * Task class for beautifying PHP files
 */
class BeautifyShell extends Shell
{
    /**
     * initialization callback
     *
     * @var string
     * @access public
     */
    function initialize()
    {
        $this->_welcome();
        $this->out('Beautify all *.php files in app folder');
        $this->hr();
    }
    /**
     * Override main
     *
     * @access public
     */
    function main($working_path = null)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . 'D:\Program Files\xampp\php\pear\\' . PATH_SEPARATOR . 'D:\Program Files\Devl\Plugins\CodeBeautifier' . PATH_SEPARATOR . 'F:\R. Rajesh Jeba Anbiah\Projects\Devl\devl\trunk\devl\Plugins\CodeBeautifier');
        if (!@include_once 'PHP/Beautifier.php') {
            $this->out('PEAR PHP Beautifier not found');
            $this->_stop();
        }
        $this->oBeautifier1 = new PHP_Beautifier();
        $this->oBeautifier2 = new PHP_Beautifier();
		if(!empty($working_path)){
			$this->__beautify_file($working_path);		
		} else {
			$this->__beautify_recursive(APP);
		}
        $this->out('done');
    }
    function __beautify_recursive($dir)
    {
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..' && $readdir != '.svn') {
                $path = $dir . DS . $readdir;
                if (is_dir($path)) {
                    $this->__beautify_recursive($path);
                }
                if (is_file($path) && (strpos($path, '.php') !== false)) {
                    $contents = file_get_contents($path);
                    $this->oBeautifier1->addFilter('Lowercase');
                    $this->oBeautifier1->setInputString($contents);
                    $this->oBeautifier1->process();
                    //
                    $this->oBeautifier2->addFilter('Pear');
                    $this->oBeautifier2->addFilter('ArrayNested');
                    $this->oBeautifier2->setIndentChar(' ');
                    $this->oBeautifier2->setIndentNumber(4);
                    $this->oBeautifier2->setNewLine("\n");
                    $this->oBeautifier2->setInputString($this->oBeautifier1->get());
                    $this->oBeautifier2->process();
                    $contents_beautified = $this->oBeautifier2->get();
                    $path_out = $path;
                    if ($contents == $contents_beautified) {
                        $this->out($path_out . ' - skipped');
                    } else {
                        file_put_contents($path, $contents_beautified);
                        $this->out($path_out . ' - beautified');
                    }
                    unset($contents);
                    unset($contents_beautified);
                }
            }
        }
        closedir($handle);
    }
	function __beautify_file($path)
    {
		if (is_file($path) && (strpos($path, '.php') !== false)) {
			$b_contents = file_get_contents($path);
			$this->oBeautifier1->addFilter('Lowercase');
			$this->oBeautifier1->setInputString($b_contents);
			$this->oBeautifier1->process();
			//
			$this->oBeautifier2->addFilter('Pear');
			$this->oBeautifier2->addFilter('ArrayNested');
			$this->oBeautifier2->setIndentChar(' ');
			$this->oBeautifier2->setIndentNumber(4);
			$this->oBeautifier2->setNewLine("\n");
			$this->oBeautifier2->setInputString($this->oBeautifier1->get());
			$this->oBeautifier2->process();
			echo $path." has been beautified. \n";
			unset($b_contents);
			unset($contents_beautified);
		}
    }
    function help()
    {
        $this->out(__('Beautify PHP files (*.php):', true));
        $this->hr();
        $this->out(__('By default -app is ROOT/app', true));
        $this->hr();
        $this->out(__('usage: cake beautify [command]', true));
        $this->out('');
        $this->out(__('commands:', true));
        $this->out(__('   -app [path...]: directory where your application is located', true));
        $this->out('');
    }
}
?>