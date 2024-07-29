<?php

namespace Ednar28\Accounting;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ednar28\Accounting\Skeleton\SkeletonClass
 */
class AccountingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'accounting';
    }
}
