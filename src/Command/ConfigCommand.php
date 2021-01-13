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
class ConfigCommand extends AbstractCommand
{
    protected $name = 'opcache:config';

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('Show your OPcache configuration');
    }

    public function handle(): void
    {
        $result = $this->opcache->getConfig();
        if (! $result) {
            $this->output->error('OPcache not configured');

            return;
        }

        $this->info('Version info:');
        $this->table([], $this->parseTable($result['version']));

        $this->info(PHP_EOL . 'Configuration info:');
        $this->table([], $this->parseTable($result['directives']));
    }

    /**
     * Make up the table for console display.
     *
     * @param array $input
     *
     * @return array
     */
    protected function parseTable(array $input): array
    {
        return array_map(static function ($key, $value) {
            $bytes = ['opcache.memory_consumption'];

            if (in_array($key, $bytes, true)) {
                $value = number_format($value / 1048576, 2) . ' MB';
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            return [
                'key' => $key,
                'value' => $value,
            ];
        }, array_keys($input), $input);
    }
}
