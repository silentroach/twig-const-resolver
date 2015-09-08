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

Without this extension Twig will compile it in something like this:

```php
if (((isset($context["usertype"]) ? $context["usertype"] : null) == twig_constant("Users::TYPE_TROLL"))) {
    // twig_constant will be evaluated in runtime
    echo "Bye-bye";
} else {
    echo "Hello";
}
```

It will be compiled even if you have no constant with that name. So you will get an error in production.

With this extension you can avoid this types of errors cause it will evaluate constants at the build step, so this template will be compiled in something like this:

```php
if (((isset($context["usertype"]) ? $context["usertype"] : null) == Users::TYPE_TROLL)) {
    // constant is resolved at the build step (Users::TYPE_TROLL)
    echo "Bye-bye";
} else {
    echo "Hello";
}
```

Also in evaluation mode it can be compiled in something like this:

```php
if (((isset($context["usertype"]) ? $context["usertype"] : null) == 2)) {
    // constant is resolved and evaluated at the build step (Users::TYPE_TROLL => 2)
    echo "Bye-bye";
} else {
    echo "Hello";
}
```

## Installation

The extension is installable via composer:

```json
{
    "require": {
        "silent/twig-const-resolver": "~1.1"
    }
}
```

## Setup

```php
$twig->addExtension(
    /**
     * @param $evaluate bool Evaluate consts (default: false)
     */
    new \silent\Twig\ConstantResolverExtension\Extension()
);
```
