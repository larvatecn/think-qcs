<?php

namespace Larva\ThinkQcs;

use think\Facade;

/**
 * @method static array check(string $contents)
 * @method static bool validate(string $contents, string $strategy = 'strict')
 * @method static string mask(string $contents, string $strategy = 'strict', string $char = '*')
 * @method static \Larva\ThinkQcs\Moderators\Tms setStrategy(string $name, callable $fn)
 */
class Tms extends Facade
{
    protected static function getFacadeClass(): string
    {
        return 'tms';
    }
}
