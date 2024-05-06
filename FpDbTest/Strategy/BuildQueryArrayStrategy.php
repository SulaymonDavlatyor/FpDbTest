<?php

namespace Strategy;

use Exception;
use Exception\DatabaseException;
use FpDbTest\Database;

class BuildQueryArrayStrategy extends AbstractBuildQueryStrategy
{
    public const TYPE = 'Array';

    /**
     * @param $value
     * @return string
     */
    public function replace($value): string
    {
        if ($value == Database::SKIP) {
            return $value;
        }
        if (!is_array($value)) {
            throw DatabaseException::wrongDataForThisStrategy(self::TYPE);
        }
        $setParts = [];

        if (!array_is_list($value)) {
            foreach ($value as $column => $val) {
                $escapedColumn = $this->escapeIdentifier($column);
                $formattedValue = $this->formatValue($val);
                $setParts[] = "{$escapedColumn} = {$formattedValue}";
            }
        } else {
            foreach ($value as $val) {
                $formattedValue = $this->formatValue($val);
                $setParts[] = $formattedValue;
            }
        }

        return implode(', ', $setParts);
    }
}
