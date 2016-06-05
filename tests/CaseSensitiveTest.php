<?php
namespace vipnytt\RobotsTxtParser\Tests;

use vipnytt\RobotsTxtParser;

/**
 * Class CaseSensitiveTest
 *
 * @package vipnytt\RobotsTxtParser\Tests
 */
class CaseSensitiveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $robotsTxtContent
     * @param string|false $rendered
     */
    public function testCaseSensitive($robotsTxtContent, $rendered)
    {
        $parser = new RobotsTxtParser\Basic('http://example.com', 200, $robotsTxtContent);
        $this->assertInstanceOf('vipnytt\RobotsTxtParser\Basic', $parser);

        $this->assertTrue($parser->userAgent('uppercase')->isDisallowed("/"));
        $this->assertFalse($parser->userAgent('uppercase')->isAllowed("/"));
        $this->assertTrue($parser->userAgent('UPPERCASE')->isDisallowed("/"));
        $this->assertFalse($parser->userAgent('UPPERCASE')->isAllowed("/"));

        $this->assertTrue($parser->userAgent('uppercase')->isDisallowed("/info/"));
        $this->assertFalse($parser->userAgent('uppercase')->isAllowed("/info/"));
        $this->assertTrue($parser->userAgent('UPPERCASE')->isDisallowed("/info/"));
        $this->assertFalse($parser->userAgent('UPPERCASE')->isAllowed("/info/"));

        $this->assertTrue($parser->userAgent('uppercase')->isDisallowed("/INFO/"));
        $this->assertFalse($parser->userAgent('uppercase')->isAllowed("/INFO/"));
        $this->assertTrue($parser->userAgent('UPPERCASE')->isDisallowed("/INFO/"));
        $this->assertFalse($parser->userAgent('UPPERCASE')->isAllowed("/INFO/"));

        $this->assertTrue($parser->userAgent('uppercase')->isAllowed("/InFo/"));
        $this->assertFalse($parser->userAgent('uppercase')->isDisallowed("/InFo/"));
        $this->assertTrue($parser->userAgent('UPPERCASE')->isAllowed("/InFo/"));
        $this->assertFalse($parser->userAgent('UPPERCASE')->isDisallowed("/InFo/"));

        $this->assertTrue($parser->userAgent('lowercase')->isDisallowed("/"));
        $this->assertFalse($parser->userAgent('lowercase')->isAllowed("/"));
        $this->assertTrue($parser->userAgent('LOWERCASE')->isDisallowed("/"));
        $this->assertFalse($parser->userAgent('LOWERCASE')->isAllowed("/"));

        $this->assertTrue($parser->userAgent('lowercase')->isDisallowed("/info/"));
        $this->assertFalse($parser->userAgent('lowercase')->isAllowed("/info/"));
        $this->assertTrue($parser->userAgent('LOWERCASE')->isDisallowed("/info/"));
        $this->assertFalse($parser->userAgent('LOWERCASE')->isAllowed("/info/"));

        $this->assertTrue($parser->userAgent('lowercase')->isDisallowed("/INFO/"));
        $this->assertFalse($parser->userAgent('lowercase')->isAllowed("/INFO/"));
        $this->assertTrue($parser->userAgent('LOWERCASE')->isDisallowed("/INFO/"));
        $this->assertFalse($parser->userAgent('LOWERCASE')->isAllowed("/INFO/"));

        $this->assertTrue($parser->userAgent('lowercase')->isAllowed("/iNfO/"));
        $this->assertFalse($parser->userAgent('lowercase')->isDisallowed("/iNfO/"));
        $this->assertTrue($parser->userAgent('LOWERCASE')->isAllowed("/iNfO/"));
        $this->assertFalse($parser->userAgent('LOWERCASE')->isDisallowed("/iNfO/"));

        $this->assertTrue($parser->userAgent('*')->isAllowed("/"));
        $this->assertFalse($parser->userAgent('*')->isDisallowed("/"));
        $this->assertTrue($parser->userAgent()->isAllowed("/"));
        $this->assertFalse($parser->userAgent()->isDisallowed("/"));

        if ($rendered !== false) {
            $this->assertEquals($rendered, $parser->render());
            $this->testCaseSensitive($rendered, false);
        }
    }

    /**
     * Generate test data
     *
     * @return array
     */
    public function generateDataForTest()
    {
        return [
            [
                <<<ROBOTS
User-agent: UPPERCASE
Disallow: /
Allow: /InFo/

User-agent: lowercase
Disallow: /
Allow: /iNfO/
ROBOTS
                ,
                <<<RENDERED
user-agent:lowercase
disallow:/
allow:/iNfO/
user-agent:uppercase
disallow:/
allow:/InFo/
RENDERED
            ]
        ];
    }
}
