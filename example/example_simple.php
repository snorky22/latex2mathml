<?php
// A minimal, debug-friendly example to convert LaTeX to MathML

// 1) Make errors visible for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// 2) Load only what is necessary
$base = dirname(__DIR__) . '/files/';
require_once $base . 'config.class.php';
require_once $base . 'commands.class.php';
require_once $base . 'latex2xml.class.php';
require_once $base . 'config.php'; // defines symbols/commands/operators

// 3) Sanity check to help diagnose include issues
if (!class_exists('Latex2MathML\\LaTeX2Xml')) {
    http_response_code(500);
    echo "Initialization error: class \\Latex2MathML\\LaTeX2Xml not found. Check requires.";
    exit(1);
}

// 4) Obtain LaTeX input
// - CLI: php example_simple.php "\\frac{a}{b}"
// - Web: /example/example_simple.php?latex=\frac{a}{b}
$input = '\\frac{a}{b}';
if (PHP_SAPI === 'cli') {
    if (isset($argv[1]) && $argv[1] !== '') {
        $input = (string)$argv[1];
    }
} else {
    if (isset($_GET['latex']) && $_GET['latex'] !== '') {
        $input = (string)$_GET['latex'];
    }
}

// 5) Convert
$l2xml = \Latex2MathML\LaTeX2Xml::getInstance();
$l2xml->parseMath($input);
$xml = $l2xml->parse();

// 6) Output in a debug-friendly way
if (PHP_SAPI !== 'cli') {
    // Using text/plain makes it easy to view the raw XML while debugging
    header('Content-Type: text/plain; charset=utf-8');
}
echo $xml, (PHP_SAPI === 'cli' ? PHP_EOL : '');

// Tips:
// - Set breakpoints in files/latex2xml.class.php methods like _parseExpr or _parseFormula
// - Run from CLI for quick iteration or use your IDE's built-in server/debugger

?>
