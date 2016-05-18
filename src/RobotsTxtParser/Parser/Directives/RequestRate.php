<?php
namespace vipnytt\RobotsTxtParser\Parser\Directives;

use vipnytt\RobotsTxtParser\Parser\RobotsTxtInterface;
use vipnytt\RobotsTxtParser\Parser\Toolbox;

/**
 * Class RequestRate
 *
 * @package vipnytt\RobotsTxtParser\Parser\Directives
 */
class RequestRate implements DirectiveInterface, RobotsTxtInterface
{
    use Toolbox;

    /**
     * Directive
     */
    const DIRECTIVE = self::DIRECTIVE_REQUEST_RATE;

    /**
     * RequestRate array
     * @var array
     */
    protected $array = [];

    /**
     * RequestRate constructor.
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
        $array = preg_split('/\s+/', $line, 2);
        $result = [
            'rate' => $this->draftParseRate($array[0]),
        ];
        if ($result['rate'] === false) {
            return false;
        } elseif (
            !empty($array[1]) &&
            ($times = $this->draftParseTime($array[1])) !== false
        ) {
            $result = array_merge($result, $times);
        }
        $this->array[] = $result;
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
        foreach ($this->array as $array) {
            $suffix = 's';
            if (
                isset($array['from']) &&
                isset($array['to'])
            ) {
                $suffix .= ' ' . $array['from'] . '-' . $array['to'];
            }
            $result[] = self::DIRECTIVE . ':1/' . $array['rate'] . $suffix;
        }
        return $result;
    }
}