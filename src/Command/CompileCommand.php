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

use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class CompileCommand extends AbstractCommand
{
    protected $name = 'opcache:compile';

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('Pre-compile your application code');
        $this->addOption('force', 'f', InputOption::VALUE_OPTIONAL, '', false);
    }

    public function handle(): void
    {
        $this->info('Compiling scripts...');

        $force = $this->input->getOption('force');

        $result = $this->opcache->compile($force);

        if (isset($result['message'])) {
            $this->output->warning($result['message']);

            return;
        }

        if ($result) {
            $this->output->success(sprintf(
                '%s of %s files compiled',
                $result['compiled_count'],
                $result['total_files_count']
            ));
            return;
        }

        $this->output->error('OPcache not configured');
    }
}
