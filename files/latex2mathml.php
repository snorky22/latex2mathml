<?php

// PHP 8+: use E_ALL only (E_STRICT removed)
error_reporting(E_ALL);

if(@stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
	header("Content-type: application/xhtml+xml; charset=utf-8");
else
	header("Content-type: text/html; charset=utf-8"); 

require('config.class.php');
require('commands.class.php');
require('config.php');
require('latex2xml.class.php');

$m = memory_get_usage();

// Use singleton accessor
$l2xml = \Latex2MathML\LaTeX2Xml::getInstance();

// Default settings for CLI usage; if running via web, fall back to file.tex/stdout
if (!isset($setting) || !is_array($setting)) {
    if (PHP_SAPI === 'cli') {
        $setting = array('filename' => 'stdin', 'output' => 'stdout');
    } else {
        $setting = array('filename' => 'file.tex', 'output' => 'stdout');
    }
}


if($setting['filename'] == 'stdin')
{
    $str = '';
    $argc = isset($_SERVER['argc']) ? (int)$_SERVER['argc'] : 0;
    $nbArgs = ($setting['output'] == 'stdout') ? $argc : max(0, $argc-2);

    for($i = 1; $i < $nbArgs; $i++)
    {
        if (isset($_SERVER['argv'][$i])) {
            $str.=$_SERVER['argv'][$i].' ';
        }
    }

        $l2xml->parseMath($str);

}
else
{
    $content = @file_get_contents($setting['filename']);
    if ($content === false) { $content = ''; }
    $l2xml->parseMath($content);
}
if($setting['output'] == 'stdout')
{
    echo $l2xml->parse();
}
else
{
    @file_put_contents($setting['output'], $l2xml->parse());
}
//echo (memory_get_usage()-$m)/1024;

?>

