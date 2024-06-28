<?php

namespace Textandbytes\StatamicRubytext\Extensions;

use Tiptap\Core\Node;

class RubyText extends Node
{
    public static $name = 'rubyText';

    public function renderHTML($node)
    {
        return [
            'rt',
            [],
            0,
        ];
    }
}
