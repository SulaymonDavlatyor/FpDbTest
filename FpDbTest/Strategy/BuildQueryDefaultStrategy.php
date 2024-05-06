<?php

namespace Strategy;

use FpDbTest\Database;

class BuildQueryDefaultStrategy extends AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return float|int|string
     */
    public function replace($value): float|int|string
    {
        if ($value == Database::SKIP) {
            return $value;
        }
        return $this->formatValue($value);
    }
}
