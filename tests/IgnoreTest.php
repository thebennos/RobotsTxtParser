<?php
namespace vipnytt\RobotsTxtParser\Tests;

use vipnytt\RobotsTxtParser\Client;

/**
 * Class IgnoreTest
 *
 * @package vipnytt\RobotsTxtParser\Tests
 */
class IgnoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $robotsTxtContent
     * @param string|false $rendered
     */
    public function testIgnore($robotsTxtContent, $rendered = '')
    {
        $parser = new Client('http://example.com', 200, $robotsTxtContent);
        $this->assertInstanceOf('vipnytt\RobotsTxtParser\Parser', $parser);

        $this->assertTrue($parser->userAgent('*')->isAllowed('/tech'));
        $this->assertFalse($parser->userAgent('*')->isDisallowed('/tech'));
        $this->assertTrue($parser->userAgent()->isAllowed('/tech'));
        $this->assertFalse($parser->userAgent()->isDisallowed('/tech'));

        if ($rendered !== false) {
            $this->assertSame($rendered, $parser->render());
            $this->testIgnore($rendered, false);
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
User-agent: *
#Disallow: /tech
ROBOTS
            ],
            [
                <<<ROBOTS
User-agent: *
Disallow: #/tech
ROBOTS
            ],
            [
                <<<ROBOTS
User-agent: *
Disal#low: /tech
ROBOTS
            ],
            [
                <<<ROBOTS
User-agent: *
Disallow#: /tech # ds
ROBOTS
            ]
        ];
    }
}