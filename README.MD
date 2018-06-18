# Php Formula Calculate Class

----------------
copyright	:	(c) BardiQi

contact us	:	bardoqi@gmail.com 

license:	:	http://open-real-estate.info/en/license

Php Formula Calculate Class is a library for parsing and evaluating mathematical formulas given as strings.


Supports:

* Operators: +, -, *, /, ^
* Variables: Any letter or word.
* Numbers with decimal point '.'
* Functions: all php math finctions,such as sin,sqrt...
* Unlimited nested parentheses

Installation
------------

Requires [PHP 5.4 or higher](http://php.net).

To install with [Composer](https://getcomposer.org):

``` sh
composer require BaroQi/Php-Formula-Calculate-Class
```


# Usage

``` php

use Bulo\Library\Std\MathUtil;

$expression = 'x+(sqrt(5)-1)/2';
$varibles = (['x' => 1]);

try {
    $ret = MathUtil::parseExpression($expression,$varibles);
    echo $ret; //2.6180339
} catch (\Exception $e) {
    echo $e->getMessage(), "\n";
}
```

It is very simple! Please to read the comment.

# ChangeLog
Fixed the bug: Only could running in php5. Now it could running in php7.
Enhance support for php7.2 .

Fixed the bug: Return false when division by zero. Now throw a new Exception.
