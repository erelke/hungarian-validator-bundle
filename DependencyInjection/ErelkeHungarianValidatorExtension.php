<?php

namespace Erelke\HungarianValidatorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ErelkeHungarianValidatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->processConfiguration(new Configuration(), $configs);
    }

    public function getAlias(): string
    {
        return 'erelke_hungarian_validator';
    }
}
