<?php

use \silent\Twig\ConstantResolverExtension\StaticConstantExpression;

class StaticConstantExpressionTest extends \PHPUnit_Framework_TestCase
{
    const SOME_VALUE = 12345;

    /**
     * @var Twig_Environment
     */
    private $environment;

    public function setUp()
    {
        $this->environment = new Twig_Environment(
            $this->getMock(Twig_LoaderInterface::class),
            [
                'cache' => false,
                'autoescape' => false
            ]
        );

        $this->environment->addExtension(new \silent\Twig\ConstantResolverExtension\Extension());
    }

    public function testCompileSimple()
    {
        $expression = new StaticConstantExpression('PHP_INT_MAX', 1);
        $this->assertEquals('PHP_INT_MAX', $this->environment->getCompiler()->compile($expression)->getSource());
    }

    public function testCompileClass()
    {
        $expression = new StaticConstantExpression('\StaticConstantExpressionTest::class', 1);
        $this->assertEquals('\StaticConstantExpressionTest::class', $this->environment->getCompiler()->compile($expression)->getSource());
    }

    public function testCompileClassConstant()
    {
        $expression = new StaticConstantExpression('\StaticConstantExpressionTest::SOME_VALUE', 1);
        $this->assertEquals('\StaticConstantExpressionTest::SOME_VALUE', $this->environment->getCompiler()->compile($expression)->getSource());
    }
}
