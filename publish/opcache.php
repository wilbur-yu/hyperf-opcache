<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  wenber.yu@creative-life.club
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'directories' => [
        BASE_PATH . '/app',
        BASE_PATH . '/bin',
        BASE_PATH . '/config',
        BASE_PATH . '/vendor',
    ],
    'exclude_dirs' => [
        'test',
        'Test',
        'tests',
        'Tests',
        'stub',
        'Stub',
        'stubs',
        'Stubs',
        'dumper',
        'Dumper',
        'Autoload',
        'swoole',
        'jetbrains',
        'symfony/polyfill-intl-idn',
    ],

    'exclude_files' => [
        'bootstrap80.php',
    ],
];
