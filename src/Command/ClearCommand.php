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

use Hyperf\Command\Annotation\Command;

/**
 * @Command
 */
class ClearCommand extends AbstractCommand
{
    protected $name = 'opcache:clear';

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('Clear OPCache');
    }

    public function handle(): void
    {
        $result = $this->opcache->clear();

        if ($result) {
            $this->output->success('OPcache cleared');
        } else {
            $this->output->error('OPcache not configured');
        }
    }
}
