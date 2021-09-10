<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81e558d8e05b195efcd4f4061bd8127b
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Yiyu\\Conf\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Yiyu\\Conf\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit81e558d8e05b195efcd4f4061bd8127b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81e558d8e05b195efcd4f4061bd8127b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81e558d8e05b195efcd4f4061bd8127b::$classMap;

        }, null, ClassLoader::class);
    }
}
