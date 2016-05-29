<?php
namespace vipnytt\RobotsTxtParser\Parser\Directives;

use vipnytt\RobotsTxtParser\RobotsTxtInterface;

/**
 * Class CommentParser
 *
 * @package vipnytt\RobotsTxtParser\Parser\Directives
 */
class CommentParser implements ParserInterface, RobotsTxtInterface
{
    /**
     * Directive
     */
    const DIRECTIVE = self::DIRECTIVE_COMMENT;

    /**
     * Comment array
     * @var string[]
     */
    private $array = [];

    /**
     * Comment constructor.
     */
    public function __construct()
    {
    }

    /**
     * Add
     *
     * @param string $line
     * @return bool
     */
    public function add($line)
    {
        $this->array[] = $line;
        return true;
    }

    /**
     * Export rules
     *
     * @return string[][]
     */
    public function export()
    {
        return empty($this->array) ? [] : [self::DIRECTIVE => $this->array];
    }

    /**
     * Render
     *
     * @return string[]
     */
    public function render()
    {
        $result = [];
        foreach ($this->array as $value) {
            $result[] = self::DIRECTIVE . ':' . $value;
        }
        return $result;
    }
}