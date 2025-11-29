<?php

// PHP 8+: use E_ALL only (E_STRICT removed)
error_reporting(E_ALL);

if(@stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
    header("Content-type: application/xhtml+xml; charset=utf-8");
else
    header("Content-type: text/html; charset=utf-8"); 

require('latex2xml.class.php');
require('config.class.php');
require('commands.class.php');
require('config.php');

$m = memory_get_usage();

$l2xml = \Latex2MathML\LaTeX2Xml::getInstance();

if(isset($_POST['message']))
{
    // get_magic_quotes_gpc was removed in PHP 7.4; trust raw POST data
    $l2xml->parseMath($_POST['message']);
}
else
{
    $l2xml->parseMath(@file_get_contents('file.tex'));
}

echo $l2xml->parse();

?>

