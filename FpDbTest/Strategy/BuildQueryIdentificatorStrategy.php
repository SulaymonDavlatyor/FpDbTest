<?php

namespace Strategy;

class BuildQueryIdentificatorStrategy extends AbstractBuildQueryStrategy
{
    /**
     * @param $value
     * @return string
     */
    public function replace($value): string
    {
        if ($value == Database::SKIP) {
            return $value;
        }
        if (is_array($value)) {
            return implode(', ', array_map([$this, 'escapeIdentifier'], $value));
        }
        return $this->escapeIdentifier($value);
    }
}
