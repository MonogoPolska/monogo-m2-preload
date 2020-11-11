<?php

/**
 * Method preload
 *
 * Borrowed the preload function implementation from
 * Dmitry Stogov's RFC https://wiki.php.net/rfc/preload
 * with minor change
 *
 * @param mixed  $preload
 * @param array  $ignore
 * @param string $pattern
 */
function preload($preload, array $ignore = [], string $pattern = "/\.php$/")
{
    if (is_array($preload)) {
        foreach ($preload as $path) {
            preload($path, $ignore, $pattern);
        }
    } else {
        if (is_string($preload)) {
            $path = $preload;
            if (!in_array($path, $ignore)) {
                if (is_dir($path)) {
                    if ($dh = opendir($path)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file !== "." && $file !== "..") {
                                preload($path . "/" . $file, $ignore, $pattern);
                            }
                        }
                        closedir($dh);
                    }
                } else {
                    if (is_file($path) && preg_match($pattern, $path)) {
                        if (!opcache_is_script_cached($path)) {
                            opcache_compile_file($path);
                        }
                    }
                }
            }
        }
    }
}

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__));
preload(
    [
        __DIR__ . '/generated/metadata',
        __DIR__ . '/vendor/composer/include_paths.php',
        __DIR__ . '/vendor/composer/autoload_staticd.php',
        __DIR__ . '/vendor/composer/autoload_real.php',
        __DIR__ . '/vendor/composer/autoload_psr4.php',
        __DIR__ . '/vendor/composer/autoload_namespaces.php',
        __DIR__ . '/vendor/composer/autoload_files.php',
        __DIR__ . '/vendor/composer/autoload_classmap.php',
        __DIR__ . '/epp/etc/config.php',
        __DIR__ . '/epp/etc/env.php',
        __DIR__ . '/vendor/autoload.php',
    ],
    []
);
