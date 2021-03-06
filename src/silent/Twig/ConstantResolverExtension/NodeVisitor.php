<?php

namespace silent\Twig\ConstantResolverExtension;

class NodeVisitor implements \Twig_NodeVisitorInterface
{
    private $evaluate;

    /**
     * @param bool $evaluate Enable constant evaluation
     */
    public function __construct($evaluate)
    {
        $this->evaluate = $evaluate;
    }

    /**
     * {@inheritdoc}
     */
    public function enterNode(\Twig_NodeInterface $node, \Twig_Environment $env)
    {
        if ($node instanceof \Twig_Node_Expression_Function
            && 'constant' === $node->getAttribute('name')
            && 1 === $node->count()
            && null !== ($resolved = $this->resolve($node))
        ) {
            return $this->resolve($node);
        }

        return $node;
    }

    /**
     * @param \Twig_Node_Expression_Function $node
     * @return mixed
     * @throws \Twig_Error
     */
    private function resolve(\Twig_Node_Expression_Function $node)
    {
        $args = $node->getNode('arguments');

        if ($args instanceof \Twig_Node
            && 1 === $args->count()
        ) {
            $constNode = $args->getNode(0);

            if ($constNode instanceof \Twig_Node_Expression_Constant
                && null !== $value = $constNode->getAttribute('value')
            ) {
                if (!defined($value)) {
                    throw new \Twig_Error(
                        sprintf(
                            "Can't resolve constant('%s')",
                            $value
                        )
                    );
                }

                if ($this->evaluate) {
                    return new \Twig_Node_Expression_Constant(constant($value), $node->getLine());
                } else {
                    return new StaticConstantExpression($value, $node->getLine());
                }
            }
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function leaveNode(\Twig_NodeInterface $node, \Twig_Environment $env)
    {
        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
