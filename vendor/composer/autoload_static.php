<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd88bcfd6e761bcb6171448f63e743a7c
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPackio\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPackio\\' => 
        array (
            0 => __DIR__ . '/..' . '/wpackio/enqueue/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd88bcfd6e761bcb6171448f63e743a7c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd88bcfd6e761bcb6171448f63e743a7c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd88bcfd6e761bcb6171448f63e743a7c::$classMap;

        }, null, ClassLoader::class);
    }
}