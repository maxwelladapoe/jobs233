<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Maxwell Adapoe <maxwelladapoe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MaxwellAdapoe\PasswordIsTooCommon\Facades;

use Illuminate\Support\Facades\Facade;

class PasswordIsTooCommon extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-password-is-too-common';
    }
}
