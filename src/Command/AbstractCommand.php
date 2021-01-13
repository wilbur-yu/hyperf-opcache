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
namespace Wilbur\HyperfOpcache\Command;

use Hyperf\Command\Command;
use Psr\Container\ContainerInterface;
use Wilbur\HyperfOpcache\Opcache;

abstract class AbstractCommand extends Command
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var \WilburYu\HyperfOpcache\Opcache
     */
    protected $opcache;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->opcache = $container->get(Opcache::class);

        parent::__construct();
    }
}
