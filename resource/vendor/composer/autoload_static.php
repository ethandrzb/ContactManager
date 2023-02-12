<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06b4c70f1e57fd54153a37fcaf8a7d52
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Clock\\' => 10,
        ),
        'L' => 
        array (
            'Lcobucci\\JWT\\' => 13,
            'Lcobucci\\Clock\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Clock\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/clock/src',
        ),
        'Lcobucci\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/jwt/src',
        ),
        'Lcobucci\\Clock\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/clock/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06b4c70f1e57fd54153a37fcaf8a7d52::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06b4c70f1e57fd54153a37fcaf8a7d52::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit06b4c70f1e57fd54153a37fcaf8a7d52::$classMap;

        }, null, ClassLoader::class);
    }
}