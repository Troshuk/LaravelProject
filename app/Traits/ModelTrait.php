<?php

namespace App\Traits;

trait ModelTrait
{
    public static $friendlyModelName = null;

    /**
     * Converts camelCase string to have spaces between each word.
     * @param $camelCaseString
     * @return string
     * @author Denys Troshuk
     */
    public static function fromCamelCase($camelCaseString)
    {
        return trim(ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', $camelCaseString)));
    }

    /**
     * Returns Friendly Model Name
     * if $friendlyModelName is not set up make new one from class name without namespase
     * @return string
     * @author Denys Troshuk
     */
    public static function getModelFriendlyName(): string
    {
        return self::$friendlyModelName ?? self::fromCamelCase(class_basename(get_called_class()));
    }

    /**
     * Make custom error on fail
     * @param  mixed $arguments
     * @return Model
     * @author Denys Troshuk
     */
    public static function findOrFail(...$arguments): self
    {
        return self::find(...$arguments) ?? abort(404, self::getModelFriendlyName() . ' was not found');
    }

    /**
     * Make custom error on fail
     * @param  mixed $arguments
     * @return Model
     * @author Denys Troshuk
     */
    public static function firstOrFail(...$arguments): self
    {
        return parent::first(...$arguments) ?? abort(404, self::getModelFriendlyName() . ' was not found');
    }
}
