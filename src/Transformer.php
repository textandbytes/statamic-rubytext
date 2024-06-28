<?php

namespace Textandbytes\StatamicRubytext;

/*
* This class converts the ruby mark data to ruby node and rubyText
* node data. This is needed because rendering multiple nested tags
* from a single mark doesn't work in tiptap-php, so the only way to
* acheive the desired HTML output is to make them nodes instead.
*
* https://github.com/ueberdosis/tiptap-php/issues/43
*/

class Transformer
{
    public static function transform($value)
    {
        return self::process(['content' => $value])['content'];
    }

    protected static function process($node)
    {
        $nodeType = $node['type'] ?? null;

        if ($nodeType === 'text') {
            $markIndex = collect($node['marks'] ?? [])
                ->search(fn ($mark) => $mark['type'] === 'ruby');
            if ($markIndex !== false) {
                $mark = $node['marks'][$markIndex];
                unset($node['marks'][$markIndex]);
                $node['marks'] = array_values($node['marks']);
                $node = [
                    'type' => 'ruby',
                    'content' => [
                        $node,
                        [
                            'type' => 'rubyText',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $mark['attrs']['text'],
                                ],
                            ],
                        ],
                    ],
                ];
            }
        }

        foreach (($node['content'] ?? []) as $i => $item) {
            $node['content'][$i] = self::process($item);
        }

        return $node;
    }
}
