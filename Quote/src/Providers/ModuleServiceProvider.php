<?php

namespace Webkul\Quote\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\Quote\Models\Quote::class
    ];
}