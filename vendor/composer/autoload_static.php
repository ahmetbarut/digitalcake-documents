<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit05e5dfff61fd54fa299decdc75721ddb
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Digitalcake\\Documents\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Digitalcake\\Documents\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit05e5dfff61fd54fa299decdc75721ddb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit05e5dfff61fd54fa299decdc75721ddb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit05e5dfff61fd54fa299decdc75721ddb::$classMap;

        }, null, ClassLoader::class);
    }
}
