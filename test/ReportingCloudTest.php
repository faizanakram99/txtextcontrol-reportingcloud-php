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

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Class ReportingCloudTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloudTest extends AbstractReportingCloudTest
{
    use DeleteTraitTest;
    use GetTraitTest;
    use PostTraitTest;
    use PutTraitTest;

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthenticationWithEmptyCredentials(): void
    {
        $reportingCloud = new ReportingCloud();

        $reportingCloud->setUsername('');
        $reportingCloud->setPassword('');
        $reportingCloud->setApiKey('');

        $reportingCloud->getFontList();
    }

    public function testAuthenticationWithApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        $reportingCloud2 = new ReportingCloud();

        $reportingCloud2->setTest(true);
        $reportingCloud2->setApiKey($apiKey);

        $this->assertEquals($apiKey, $reportingCloud2->getApiKey());
        $this->assertContains('Times New Roman', $reportingCloud2->getFontList());

        $this->deleteAllApiKeys();

        unset($reportingCloud2);
    }

    public function testConstructorOptions(): void
    {
        $options = [
            'username' => 'phpunit-username',
            'password' => 'phpunit-password',
            'base_uri' => 'https://api.example.com',
            'timeout'  => 100,
            'version'  => 'v1',
            'debug'    => true,
            'test'     => true,
        ];

        $reportingCloud = new ReportingCloud($options);

        $this->assertSame('phpunit-username', $reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        $this->assertSame(100, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertTrue($reportingCloud->getDebug());
        $this->assertTrue($reportingCloud->getTest());

        unset($reportingCloud);
    }

    public function testSetGetProperties(): void
    {
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');
        $this->reportingCloud->setBaseUri('https://api.example.com');
        $this->reportingCloud->setTimeout(100);
        $this->reportingCloud->setVersion('v1');
        $this->reportingCloud->setDebug(true);
        $this->reportingCloud->setTest(true);

        $this->assertSame('phpunit-username', $this->reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $this->reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        $this->assertSame(100, $this->reportingCloud->getTimeout());
        $this->assertSame('v1', $this->reportingCloud->getVersion());

        $this->assertTrue($this->reportingCloud->getDebug());
        $this->assertTrue($this->reportingCloud->getTest());
    }

    public function testGetClientInstanceOf(): void
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testGetClientWithUsernameAndPassword(): void
    {
        $this->reportingCloud->setApiKey('');
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');

        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testDefaultProperties(): void
    {
        $reportingCloud = new ReportingCloud();

        $this->assertEmpty($reportingCloud->getUsername());
        $this->assertEmpty($reportingCloud->getPassword());

        $envName = 'REPORTING_CLOUD_BASE_URI';
        $baseUri = getenv($envName);
        if (is_string($baseUri) && !empty($baseUri)) {
            $expected = $baseUri;
        } else {
            $expected = 'https://api.reporting.cloud';
        }
        $this->assertSame($expected, $reportingCloud->getBaseUri());
        $this->assertSame(120, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertFalse($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testGetBaseUriFromEnvVariable(): void
    {
        $envName = 'REPORTING_CLOUD_BASE_URI';
        $baseUri = getenv($envName);
        if (is_string($baseUri) && !empty($baseUri)) {
            $reportingCloud = new ReportingCloud();
            $this->assertSame($baseUri, $reportingCloud->getBaseUri());
            unset($reportingCloud);
        }
    }

    public function testGetBaseUriFromEnvVariableWithNull(): void
    {
        $envName = 'REPORTING_CLOUD_BASE_URI';
        $baseUri = getenv($envName);

        putenv("{$envName}");

        $reportingCloud = new ReportingCloud();
        $this->assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVariableWithEmptyValue(): void
    {
        $envName = 'REPORTING_CLOUD_BASE_URI';
        $baseUri = getenv($envName);

        putenv("{$envName}=");

        $reportingCloud = new ReportingCloud();
        $this->assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVariableWithInvalidValue(): void
    {
        $envName = 'REPORTING_CLOUD_BASE_URI';
        $baseUri = getenv($envName);
        if (is_string($baseUri) && !empty($baseUri)) {
            putenv("{$envName}=https://www.example.com");
            try {
                $reportingCloud = new ReportingCloud();
                $reportingCloud->getBaseUri();
            } catch (InvalidArgumentException $e) {
                putenv("{$envName}={$baseUri}");
                $expected = 'Base URI from environment variable name "REPORTING_CLOUD_BASE_URI" with value ';
                $expected .= '"https://www.example.com" does not end in "api.reporting.cloud"';
                $this->assertSame($expected, $e->getMessage());
            }
            unset($reportingCloud);
        }
    }
}
