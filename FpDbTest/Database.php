<?php

namespace FpDbTest;

use Enum\BuildQuerySpecificationEnum;
use Exception;
use Exception\DatabaseException;
use mysqli;
use Strategy\BuildQueryArrayStrategy;
use Strategy\BuildQueryDefaultStrategy;
use Strategy\BuildQueryFloatStrategy;
use Strategy\BuildQueryIdentificatorStrategy;
use Strategy\BuildQueryIntStrategy;

class Database implements DatabaseInterface
{
    public const SKIP = '__SKIP__';
    private array $params;
    private mysqli $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }
    
    /**
     * @param string $query
     * @param array $args
     * @return string
     */
    public function buildQuery(string $query, array $args = []): string
    {
        $this->params = $args;

        $cases = implode(array_column(BuildQuerySpecificationEnum::cases(), 'value'));
        $regPattern = '/\?([%s])?/';
        $regPattern = sprintf($regPattern, $cases);

        $query = preg_replace_callback($regPattern, [$this, 'replaceCallback'], $query);

        return $this->removeSkipBlocks($query);
    }

    /**
     * @param string $query
     * @return string
     */
    private function removeSkipBlocks(string $query): string
    {
        $query = preg_replace('/\{(.*?)__SKIP__(.*?)}/', '', $query);
        $query = preg_replace('/([{}])/', '', $query);

        return $query;
    }


    /**
     * Finds necessary strategy and replaces the specificator for value
     * @param $matches
     * @return string
     */
    private function replaceCallback($matches): string
    {
        if (empty($this->params)) {
            throw DatabaseException::argumentsCountDoesntMatch();
        }
        $value = array_shift($this->params) ?? null;
        $typeSpecificator = $matches[1] ?? '';
        $typeName = BuildQuerySpecificationEnum::tryFrom($typeSpecificator)?->name ?? 'Default';
        $strategyName = 'Strategy\BuildQuery' . $typeName . 'Strategy';
        if (!class_exists($strategyName)) {
            throw DatabaseException::classDoesntExist($strategyName);
        }
        $strategy = new $strategyName();
        return $strategy->replace($value);
    }

    /**
     * @return string
     */
    public function skip(): string
    {
        return self::SKIP;
    }
}
