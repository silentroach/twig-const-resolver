# Twig Constant Resolver Extension

[![Travis](https://img.shields.io/travis/silentroach/twig-const-resolver.svg?style=flat-square&label=travis)](https://travis-ci.org/silentroach/twig-const-resolver)
[![Coveralls](https://img.shields.io/coveralls/silentroach/twig-const-resolver.svg?style=flat-square&label=coverage)](https://coveralls.io/r/silentroach/twig-const-resolver)

Simple Twig plugin to resolve constant on template cache build.

## Why

For example we have something like this:

```twig
{% if usertype == constant('Users::TYPE_TROLL') %}
    Bye-bye
{% else %}
    Hello!
{% endif %}
```

Without this extension it will be compiled in something like this:

```php
class __TwigTemplate_long_long_hash extends Twig_Template {

    protected function doDisplay(array $context, array $blocks = array()) {
        if (((isset($context["usertype"]) ? $context["usertype"] : null) == twig_constant("Users::TYPE_TROLL"))) {
            // twig_constant will be resolved in runtime
            echo "Bye-bye";
        } else {
            echo "Hello";
        }
    }

}
```

With this extension it will be compiled in something like this:

```php
class __TwigTemplate_long_long_hash extends Twig_Template {

    protected function doDisplay(array $context, array $blocks = array()) {
        if (((isset($context["usertype"]) ? $context["usertype"] : null) == 2)) {
            // constant is resolved and evaluated (2)
            echo "Bye-bye";
        } else {
            echo "Hello";
        }
    }

}
```

## Installation

The extension is installable via composer:

```json
{
    "require": {
        "silent/twig-const-resolver": "~1.0"
    }
}
```

## Setup

```php
$twig->addExtension(new \silent\Twig\ConstantResolverExtension\Extension());
```