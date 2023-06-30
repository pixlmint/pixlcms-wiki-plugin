<?php

namespace PixlMint\WikiPlugin\Hooks;

use Nacho\Hooks\AbstractHook;
use PixlMint\CMS\Contracts\InitFunction;
use PixlMint\WikiPlugin\Helpers\WikiConfiguration;

class InitHook extends AbstractHook implements InitFunction
{
    public function call(array $init): array
    {
        $init['wikiVersion'] = WikiConfiguration::version();

        return $init;
    }
}