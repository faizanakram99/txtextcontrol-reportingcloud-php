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

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Stdlib\Path;

/**
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertLanguageTrait
{
    /**
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     */
    abstract public static function oneOf($value, array $values, $message = '');

    /**
     * Check value is a valid language
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertLanguage(string $value, string $message = ''): void
    {
        $haystack = self::getDictionaries();
        $format   = $message ?: '"%s" contains an unsupported language';
        $message  = sprintf($format, $value);

        self::oneOf($value, $haystack, $message);
    }

    /**
     * Return the filename, containing languages aka dictionaries array
     *
     * @return string
     */
    public static function getDictionariesFilename(): string
    {
        return sprintf('%s/dictionaries.php', Path::data());
    }

    /**
     * Return languages aka dictionaries array
     *
     * @return array
     * @psalm-suppress UnresolvableInclude
     */
    private static function getDictionaries(): array
    {
        $filename = self::getDictionariesFilename();

        return (array) include $filename;
    }
}
