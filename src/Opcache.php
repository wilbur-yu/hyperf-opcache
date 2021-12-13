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
use Throwable;

/**
 * Class Opcache.
 */
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

        return null;
    }

    /**
     * Get configuration values.
     */
    public function getConfig(): ?array
    {
        if (function_exists('opcache_get_configuration')) {
            return opcache_get_configuration();
        }

        return null;
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

        return false;
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

        if (! function_exists('opcache_compile_file')) {
            return ['message' => 'Please install the Opcache extension'];
        }

        $compiled = 0;

        // Get files in these paths
        $files = collect(Finder::create()->in(config('opcache.directories'))
            ->name('*.php')
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->notContains('#!/usr/bin/env php')
            ->exclude(config('opcache.exclude_dirs'))
            ->files()
            ->followLinks());

        // optimized files
        $files->each(function ($file) use (&$compiled, $force) {
            $file = (string) $file;
            $array = explode('/', $file);
            $filename = array_pop($array);

            $excludeFiles = config('opcache.exclude_files');
            if (! empty($excludeFiles) && in_array($filename, config('opcache.exclude_files'), true)) {
                return;
            }
            try {
                if (opcache_is_script_cached($file)) {
                    opcache_invalidate($file, $force);
                }
                opcache_compile_file($file);

                ++$compiled;
            } catch (Throwable $e) {
            }
        });

        return [
            'total_files_count' => $files->count(),
            'compiled_count' => $compiled,
        ];
    }
}
