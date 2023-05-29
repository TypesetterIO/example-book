<?php

return [
    'theme' => 'my-theme',
    'content' => 'content',

    'title' => 'Laravel Tips from No Compromises',
    'author' => 'No Compromises',

    'toc-enabled' => true,
    'toc-links' => true,
    'toc-header' => 'Contents',

    'footer' => 'Page {PAGENO}',

    'markdown-extensions' => ['md'],

    'observers' => [
        new \Typesetterio\Typesetter\Observers\DefaultMarkdownConfiguration(),
        new \Typesetterio\Typesetter\Observers\FirstElementInChapterCSSClass(),
        new \Typesetterio\Typesetter\Observers\BreakToPageBreak(),
    ],
];
