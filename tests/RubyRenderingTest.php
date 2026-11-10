<?php

namespace Textandbytes\StatamicRubytext\Tests;

use Statamic\Fields\Field;
use Statamic\Fieldtypes\Bard;
use Statamic\Testing\AddonTestCase;
use Textandbytes\StatamicRubytext\ServiceProvider;

class RubyRenderingTest extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;

    public function test_existing_ruby_content_renders_its_pronunciation(): void
    {
        $this->assertSame('<p><ruby>漢字<rt>かんじ</rt></ruby></p>', $this->render([
            $this->paragraph('漢字', [['type' => 'ruby', 'attrs' => ['text' => 'かんじ']]]),
        ]));
    }

    public function test_ruby_preserves_other_formatting_and_surrounding_text(): void
    {
        $paragraph = $this->paragraph('漢字', [
            ['type' => 'bold'],
            ['type' => 'ruby', 'attrs' => ['text' => 'かんじ']],
        ]);
        $paragraph['content'][] = ['type' => 'text', 'text' => ' is kanji.'];

        $this->assertSame('<p><ruby><strong>漢字</strong><rt>かんじ</rt></ruby> is kanji.</p>', $this->render([$paragraph]));
    }

    public function test_ruby_inside_nested_content_escapes_the_pronunciation(): void
    {
        $html = $this->render([[
            'type' => 'bulletList',
            'content' => [[
                'type' => 'listItem',
                'content' => [$this->paragraph('漢字', [
                    ['type' => 'ruby', 'attrs' => ['text' => '<b>reading</b>']],
                ])],
            ]],
        ]]);

        $this->assertStringContainsString('<ruby>漢字<rt>&lt;b&gt;reading&lt;/b&gt;</rt></ruby>', $html);
        $this->assertStringContainsString('<ul>', $html);
    }

    public function test_text_without_ruby_is_unchanged(): void
    {
        $this->assertSame('<p>Plain text</p>', $this->render([$this->paragraph('Plain text')]));
        $this->assertNull($this->render([]));
    }

    private function paragraph(string $text, array $marks = []): array
    {
        return ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $text, 'marks' => $marks]]];
    }

    private function render(array $content): ?string
    {
        return (new Bard)->setField(new Field('body', ['type' => 'bard']))->augment($content);
    }
}
