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

        /*
        * The extra rubyText node extension and augmentation hook are needed
        * because rendering multiple nested tags from a single mark doesn't
        * work in tiptap-php. See comment in Transformer for more info.
        */
        Augmentor::addExtension('rubyText', new Extensions\RubyText());
        Bard::hook('augment', function ($value, $next) {
            return $next(Transformer::transform($value));
        });
    }
}
