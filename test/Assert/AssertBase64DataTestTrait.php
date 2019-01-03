<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertBase64DataTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertBase64DataTestTrait
{
    public function testAssertBase64Data()
    {
        $value = base64_encode('ReportingCloud rocks!');
        $this->assertNull(Assert::assertBase64Data($value));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "#*abc" must be base64 encoded
     */
    public function testAssertBase64DataInvalidCharacters()
    {
        Assert::assertBase64Data('#*abc');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "-1" must be base64 encoded
     */
    public function testAssertBase64DataInvalidDigits()
    {
        Assert::assertBase64Data('-1');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "[]" must be base64 encoded
     */
    public function testAssertBase64DataInvalidBrackets()
    {
        Assert::assertBase64Data('[]');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("**********")
     */
    public function testAssertBase64DataWithCustomMessage()
    {
        Assert::assertBase64Data('**********', 'Custom error message (%s)');
    }
}
