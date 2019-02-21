<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertReturnFormatTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertReturnFormatTestTrait
{
    // <editor-fold desc="Abstract methods">
    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertReturnFormat(): void
    {
        $fileFormat   = ReportingCloud::FILE_FORMAT_DOC;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_DOCX;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_HTML;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_PDF;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_PDFA;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_RTF;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_TX;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $fileFormat   = ReportingCloud::FILE_FORMAT_TXT;
        $fileFormatLc = strtolower($fileFormat);

        Assert::assertReturnFormat($fileFormat);
        Assert::assertReturnFormat($fileFormatLc);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported return format file extension
     */
    public function testAssertReturnFormatInvalid(): void
    {
        Assert::assertReturnFormat('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("XXX")
     */
    public function testAssertReturnFormatInvalidWithCustomMessage(): void
    {
        Assert::assertReturnFormat('XXX', 'Custom error message ("%s")');
    }
}
