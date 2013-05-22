<?php
namespace MrPrompt\Cielo;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-22 at 09:46:48.
 */
class CartaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cartao
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Cartao;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getCartao
     */
    public function testGetCartao()
    {
        $cartao = '4557759360725444';
        $this->object->setCartao($cartao);
        
        $this->assertEquals($cartao, $this->object->getCartao());
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setCartao
     */
    public function testSetCartao()
    {
        $cartao = '4557759360725444';
        $this->assertTrue($this->object->setCartao($cartao) instanceof \MrPrompt\Cielo\Cartao);
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setCartao
     */
    public function testSetCartaoInvalido()
    {
        $cartao = '455775936072';
        $this->setExpectedException('\Exception');
        $this->assertFalse($this->object->setCartao($cartao) instanceof \MrPrompt\Cielo\Cartao);
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getIndicador
     * @todo   Implement testGetIndicador().
     */
    public function testGetIndicador()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setIndicador
     * @todo   Implement testSetIndicador().
     */
    public function testSetIndicador()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getCodigoSeguranca
     * @todo   Implement testGetCodigoSeguranca().
     */
    public function testGetCodigoSeguranca()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setCodigoSeguranca
     * @todo   Implement testSetCodigoSeguranca().
     */
    public function testSetCodigoSeguranca()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getNomePortador
     * @todo   Implement testGetNomePortador().
     */
    public function testGetNomePortador()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setNomePortador
     * @todo   Implement testSetNomePortador().
     */
    public function testSetNomePortador()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getValidade
     * @todo   Implement testGetValidade().
     */
    public function testGetValidade()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setValidade
     * @todo   Implement testSetValidade().
     */
    public function testSetValidade()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::getBandeira
     * @todo   Implement testGetBandeira().
     */
    public function testGetBandeira()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers MrPrompt\Cielo\Cartao::setBandeira
     * @todo   Implement testSetBandeira().
     */
    public function testSetBandeira()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
