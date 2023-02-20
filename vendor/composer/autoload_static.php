<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc9967f4f26eec3891de92f4eeab4fcc2
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PrestaShop\\Module\\testmodule\\' => 29,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PrestaShop\\Module\\testmodule\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc9967f4f26eec3891de92f4eeab4fcc2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc9967f4f26eec3891de92f4eeab4fcc2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc9967f4f26eec3891de92f4eeab4fcc2::$classMap;

        }, null, ClassLoader::class);
    }
}