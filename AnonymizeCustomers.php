<?php

namespace AnonymizeCustomers;

use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Module\BaseModule;

class AnonymizeCustomers extends BaseModule
{
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode() . '\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR . ucfirst(self::getModuleCode()) . "/I18n/*"])
            ->autowire(true)
            ->autoconfigure(true);
    }
}
