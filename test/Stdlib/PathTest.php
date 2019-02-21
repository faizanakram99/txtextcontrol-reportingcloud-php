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

namespace TxTextControlTest\ReportingCloud\Path;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Stdlib\Path;

/**
 * Class PathTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class PathTest extends TestCase
{
    public function testRoot(): void
    {
        $expected = dirname(__FILE__, 3);
        $actual   = Path::root();
        $this->assertEquals($expected, $actual);
    }

    public function testOthers(): void
    {
        $paths = [
            'bin',
            'data',
            'demo',
            'output',
            'resource',
            'test',
        ];

        foreach ($paths as $path) {
            $expected = sprintf('%s/%s', Path::root(), $path);
            $actual   = Path::$path();
            $this->assertEquals($expected, $actual);
        }
    }
}
