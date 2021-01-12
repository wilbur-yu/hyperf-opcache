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
namespace WilburYu\HyperfOpcache;

use Symfony\Component\Finder\Finder;

class Opcache
{
    /**
     * Clear OPcache.
     */
    public function clear(): ?bool
    {
        if (function_exists('opcache_reset')) {
            return opcache_reset();
        }
    }

    /**
     * Get configuration values.
     */
    public function getConfig(): ?array
    {
        if (function_exists('opcache_get_configuration')) {
            return opcache_get_configuration();
        }
    }

    /**
     * Get status info.
     *
     * @return array|bool
     */
    public function getStatus()
    {
        if (function_exists('opcache_get_status')) {
            return opcache_get_status(false);
        }
    }

    /**
     * Pre-compile php scripts.
     *
     * @param bool $force
     *
     * @return array
     */
    public function compile($force = false): ?array
    {
        if (! $force && ! ini_get('opcache.dups_fix')) {
            return ['message' => 'opcache.dups_fix must be enabled, or run with --force'];
        }

        if (function_exists('opcache_compile_file')) {
            $compiled = 0;

            // Get files in these paths
            $files = collect(Finder::create()->in(config('opcache.directories'))
                ->name('*.php')
                ->ignoreUnreadableDirs()
                ->notContains('#!/usr/bin/env php')
                ->exclude(config('opcache.exclude_dirs'))
                ->files()
                ->followLinks());

            // optimized files
            $files->each(function ($file) use (&$compiled) {
                $array = explode('/', (string) $file);
                $filename = array_pop($array);

                if (in_array($filename, config('opcache.exclude_files'), true)) {
                    return;
                }
                try {
                    if (! opcache_is_script_cached((string) $file)) {
                        opcache_compile_file((string) $file);
                    }

                    ++$compiled;
                } catch (\Exception $e) {
                }
            });

            return [
                'total_files_count' => $files->count(),
                'compiled_count' => $compiled,
            ];
        }
    }
}
