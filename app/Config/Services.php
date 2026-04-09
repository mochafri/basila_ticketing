<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function kategori($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('kategori');
        }

        return new \App\Services\KategoriService();
    }

    public static function layanan($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('layanan');
        }

        return new \App\Services\LayananService();
    }

    public static function tiket($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('tiket');
        }

        return new \App\Services\TiketService();
    }

    public static function auth($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('auth');
        }

        return new \App\Services\AuthService();
    }

    public static function kaurstaff($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('kaurstaff');
        }

        return new \App\Services\KaurService();
    }

    public static function riwayat($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('riwayat');
        }

        return new \App\Services\RiwayatService();
    }
    
    public static function dashboard($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('dashboard');
        }

        return new \App\Services\DashboardService();
    }
}
