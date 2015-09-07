<?php

class ExtensionTest extends \PHPUnit_Framework_TestCase
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

    public function testResolve()
    {
        $stream = $this->environment->parse(
            $this->environment->tokenize('{{ constant("PHP_INT_MAX") }}', 'index')
        );

        $node = $stream->getNode('body')->getNode(0);

        $this->assertEquals(Twig_Node_Print::class, get_class($node));
        $this->assertEquals(PHP_INT_MAX, $node->getNode('expr')->getAttribute('value'));
    }

    public function testClassConstant()
    {
        $stream = $this->environment->parse(
            $this->environment->tokenize('{{ constant("ExtensionTest::SOME_VALUE") }}', 'index')
        );

        $node = $stream->getNode('body')->getNode(0);

        $this->assertEquals(Twig_Node_Print::class, get_class($node));
        $this->assertEquals(ExtensionTest::SOME_VALUE, $node->getNode('expr')->getAttribute('value'));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessageRegExp #SOME_UNKNOWN_CONST#
     */
    public function testUnresolved()
    {
        $this->environment->parse(
            $this->environment->tokenize('{{ constant("SOME_UNKNOWN_CONST") }}', 'index')
        );
    }
}
