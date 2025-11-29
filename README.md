# LaTeX2MathML

Current version: 0.1a-3 (unstable)

LaTeX2MathML is a set of PHP classes that convert LaTeX math into MathML.
Requires PHP 8.0 or higher.

## Links

- Homepage: http://latex2mathml.freewebmaster.fr (link seems broken).
- SourceForge: http://sourceforge.net/projects/latex2mathml/

## Installation

### Via Composer (recommended)

```bash
composer require latex2mathml/latex2mathml
```

Then use it in your code:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

// Load project configuration (symbols/commands/operators)
require __DIR__ . '/vendor/latex2mathml/latex2mathml/files/config.php';

$l2xml = \Latex2MathML\LaTeX2Xml::getInstance();
$l2xml->parseMath('\\frac{a}{b}');
echo $l2xml->parse();
```

### Manual (no Composer)

Clone or download the repository and include the required files:

```php
<?php
$base = __DIR__ . '/files/';
require_once $base . 'config.class.php';
require_once $base . 'commands.class.php';
require_once $base . 'latex2xml.class.php';
require_once $base . 'config.php'; // defines symbols/commands/operators

$l2xml = \Latex2MathML\LaTeX2Xml::getInstance();
$l2xml->parseMath('\\frac{a}{b}');
echo $l2xml->parse();
```

## Examples

- `example/example_simple.php` — minimal, debug-friendly example. You can pass input via CLI or `?latex=` query param.
- `example/example1.php` — larger showcase with many expressions. Seems currently broken.

## Project layout

```
files/
  config.php            # Configuration file (symbols/commands/operators)
  config.class.php      # Configuration class
  latex2xml.class.php   # Main parser class
  commands.class.php    # Define and expand custom LaTeX commands
  style.css             # Optional stylesheet
example/
  example1.php
  example_simple.php
LICENSE
README.md
composer.json
```

## Notes

- Autoload uses Composer classmap for the `files/` directory to match the current layout.
- Tested with PHP 8.0+.

## License

This project is distributed under the BSD 3-Clause License. See the [LICENSE](LICENSE) file.
