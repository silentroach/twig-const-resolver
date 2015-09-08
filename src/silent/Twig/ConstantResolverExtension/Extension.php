<?php

namespace silent\Twig\ConstantResolverExtension;

class Extension extends \Twig_Extension
{
    private $evaluate;

    /**
     * @param bool $evaluate Enable constant evaluation
     */
    public function __construct($evaluate = false)
    {
        $this->evaluate = $evaluate;
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return [
            new NodeVisitor($this->evaluate)
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
