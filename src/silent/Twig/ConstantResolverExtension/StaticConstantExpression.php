<?php
namespace silent\Twig\ConstantResolverExtension;

/**
 * Class StaticConstantExpression
 */
class StaticConstantExpression extends \Twig_Node_Expression
{
    public function __construct($expression, $lineno)
    {
        parent::__construct(array(), array('expression' => $expression), $lineno);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->raw($this->getAttribute('expression'));
    }
}
