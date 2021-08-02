<?php

namespace Larva\ThinkQcs;

use think\Facade;

/**
 * @method static array check(string $contents)
 * @method static bool validate(string $contents, string $strategy = 'strict')
 * @method static \Larva\ThinkQcs\Moderators\Ims setStrategy(string $name, callable $fn)
 */
class Ims extends Facade
{
    protected static function getFacadeClass(): string
    {
        return 'ims';
    }
}
