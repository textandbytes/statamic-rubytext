<?php

namespace Textandbytes\StatamicRubytext;

use Statamic\Fieldtypes\Bard;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        Augmentor::addExtension('ruby', new Extensions\Ruby());
        Augmentor::addExtension('rubyText', new Extensions\RubyText());

        Bard::hook('augment', function ($value, $next) {
            return $next(Transformer::transform($value));
        });
    }
}
