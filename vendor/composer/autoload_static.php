<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc7408059cd3c00140ac1e561f7cc38dc
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'ishop\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ishop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ishop/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc7408059cd3c00140ac1e561f7cc38dc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc7408059cd3c00140ac1e561f7cc38dc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc7408059cd3c00140ac1e561f7cc38dc::$classMap;

        }, null, ClassLoader::class);
    }
}
