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
namespace WilburYu\HyperfOpcache\Command;

use Hyperf\Command\Command;
use Psr\Container\ContainerInterface;
use WilburYu\HyperfOpcache\Opcache;

abstract class AbstractCommand extends Command
{
    protected ContainerInterface $container;

    protected Opcache $opcache;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->opcache = $container->get(Opcache::class);

        parent::__construct();
    }
}
