<?php

namespace Exception;

use RuntimeException;
use Throwable;

class DatabaseException extends RuntimeException
{
    public const DEFAULT_FORMAT_EXCEPTION = "Invalid type for value formatting.";
    public const WRONG_DATA_FOR_THIS_STRATEGY = "Expected %s for this strategy";
    public const CLASS_DOESNT_EXIST = "Class %s doesnt exist";
    public const ARGUMENT_COUNT_DOESNT_MATCH = "Arguments count doesnt match";

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $type
     * @return DatabaseException
     */
    public static function wrongDataForThisStrategy(string $type): DatabaseException
    {
        $message = sprintf(self::WRONG_DATA_FOR_THIS_STRATEGY, $type);
        return new DatabaseException($message);
    }

    /**
     * @return DatabaseException
     */
    public static function invalidTypeForDefaultFormat(): DatabaseException
    {
        return new DatabaseException(self::DEFAULT_FORMAT_EXCEPTION);
    }

    /**
     * @return DatabaseException
     */
    public static function argumentsCountDoesntMatch(): DatabaseException
    {
        return new DatabaseException(self::ARGUMENT_COUNT_DOESNT_MATCH);
    }

    /**
     * @param string $className
     * @return DatabaseException
     */
    public static function classDoesntExist(string $className): DatabaseException
    {
        $message = sprintf(self::CLASS_DOESNT_EXIST, $className);
        return new DatabaseException($message);
    }

}
