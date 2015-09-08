<?php

namespace silent\Twig\ConstantResolverExtension;

class NodeVisitor implements \Twig_NodeVisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function enterNode(\Twig_NodeInterface $node, \Twig_Environment $env)
    {
        if ($node instanceof \Twig_Node_Expression_Function
            && 'constant' === $node->getAttribute('name')
            && 1 === $node->count()
            && null !== ($resolved = $this->getResolvedConstant($node))
        ) {
            return new StaticConstantExpression($resolved, $node->getLine());
        }

        return $node;
    }

    /**
     * @param \Twig_Node_Expression_Function $node
     * @return mixed
     * @throws \Twig_Error
     */
    private function getResolvedConstant(\Twig_Node_Expression_Function $node)
    {
        $args = $node->getNode('arguments');

        if ($args instanceof \Twig_Node
            && 1 === $args->count()
        ) {
            $constNode = $args->getNode(0);

            if ($constNode instanceof \Twig_Node_Expression_Constant
                && null !== $value = $constNode->getAttribute('value')
            ) {
                // do not allow E_WARNING to throw
                if (null === $constantResolved = @constant($value)) {
                    throw new \Twig_Error(
                        sprintf(
                            "Can't resolve constant('%s')",
                            $value
                        )
                    );
                }

                return $value;
            }
        }

        return null;
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
