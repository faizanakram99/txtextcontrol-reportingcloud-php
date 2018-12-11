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

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertDocumentExtensionTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait AssertDocumentExtensionTrait
{
    /**
     * Validate document format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertDocumentExtension(string $value, string $message = '')
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        if (!in_array($extension, self::getDocumentFormats())) {
            $format  = '%s contains an unsupported document format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}