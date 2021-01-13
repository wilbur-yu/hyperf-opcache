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
class StatusCommand extends AbstractCommand
{
    protected $name = 'opcache:status';

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('Show OPcache status');
    }

    public function handle(): void
    {
        $result = $this->opcache->getStatus();

        if (! $result) {
            $this->output->note('Opcache 配置参考: https://learnku.com/articles/43121');
            $this->output->error('OPcache not configured');

            return;
        }

        $this->displayTables($result);
    }

    /**
     * Display info tables.
     *
     * @param array $data
     */
    protected function displayTables(array $data): void
    {
        $general = $data;

        foreach (['memory_usage', 'interned_strings_usage', 'opcache_statistics', 'preload_statistics'] as $unset) {
            unset($general[$unset]);
        }

        $this->info('Statuses:');
        $this->table([], $this->parseTable($general));

        $this->info(PHP_EOL . 'Memory usage:');
        $this->table([], $this->parseTable($data['memory_usage']));

        if (isset($data['opcache_statistics'])) {
            $this->info(PHP_EOL . 'Statistics:');
            $this->table([], $this->parseTable($data['opcache_statistics']));
        }

        if (isset($data['interned_strings_usage'])) {
            $this->info(PHP_EOL . 'Interned strings usage:');
            $this->table([], $this->parseTable($data['interned_strings_usage']));
        }

        if (isset($data['preload_statistics'])) {
            $this->info(PHP_EOL . 'Preload statistics:');
            $this->table([], $this->parseTable($data['preload_statistics']));
        }
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
        $bytes = ['used_memory', 'free_memory', 'wasted_memory', 'buffer_size'];
        $times = ['start_time', 'last_restart_time'];

        return array_map(static function ($key, $value) use ($bytes, $times) {
            if (in_array($key, $bytes, true)) {
                $value = number_format($value / 1048576, 2) . ' MB';
            } elseif (in_array($key, $times, true)) {
                $value = date('Y-m-d H:i:s', $value);
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            return [
                'key' => $key,
                'value' => is_array($value) ? implode(PHP_EOL, $value) : $value,
            ];
        }, array_keys($input), $input);
    }
}
