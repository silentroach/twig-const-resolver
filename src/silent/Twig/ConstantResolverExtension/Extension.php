<?php

namespace silent\Twig\ConstantResolverExtension;

class Extension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return [
            new NodeVisitor()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'constant_resolver';
    }
}
