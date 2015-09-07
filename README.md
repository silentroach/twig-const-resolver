# Twig Constant Resolver Extension

[![Travis](https://img.shields.io/travis/silentroach/twig-const-resolver.svg?style=flat-square&label=travis)](https://travis-ci.org/silentroach/twig-const-resolver)
[![Coveralls](https://img.shields.io/coveralls/silentroach/twig-const-resolver.svg?style=flat-square&label=coverage)](https://coveralls.io/r/silentroach/twig-const-resolver)

Simple Twig plugin to resolve constant on template cache build.

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