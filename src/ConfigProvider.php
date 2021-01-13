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
namespace Wilbur\HyperfOpcache;

use WilburYu\HyperfOpcache\Command\ClearCommand;
use WilburYu\HyperfOpcache\Command\CompileCommand;
use WilburYu\HyperfOpcache\Command\ConfigCommand;
use WilburYu\HyperfOpcache\Command\StatusCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
                ClearCommand::class,
                CompileCommand::class,
                StatusCommand::class,
                ConfigCommand::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for wilbur-yu/hyperf-opcache.',
                    'source' => __DIR__ . '/../publish/opcache.php',
                    'destination' => BASE_PATH . '/config/autoload/opcache.php',
                ],
            ],
        ];
    }
}
