<?php

namespace Textandbytes\StatamicRubytext\Extensions;

use Tiptap\Core\Node;

class Ruby extends Node
{
    public static $name = 'ruby';

    public function renderHTML($node)
    {
        return [
            'ruby',
            [],
            0,
        ];
    }
}
