<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\FilterAdmin;
use App\Filters\FilterPetugas;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>> [filter_name => classname]
     *                                                     or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin'   => FilterAdmin::class,
        'filterPetugas' => FilterPetugas::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            'filterAdmin' => [
                'except' => [
                    'login', '/'
                ]
            ],
            'filterPetugas' => [
                'except' => [
                    'login', '/'
                ]
            ]
        ],
        'after' => [
            'toolbar',
            'filterAdmin' => [
                'except' => [
                    'dashboard/*', 'dashboard', 'pengguna', 'pengguna/*',
                    'pengajuan_non_medis', 'pengajuan_non_medis/*', 'pembelian_non_medis', 'pembelian_non_medis/*',
                    'penerimaan_non_medis', 'penerimaan_non_medis/*', 'permintaan_non_medis', 'permintaan_non_medis/*',
                    'pengeluaran_non_medis', 'pengeluaran_non_medis/*',
                    'pengajuan_inventaris', 'pengajuan_inventaris/*', 'pembelian_inventaris', 'pembelian_inventaris/*',
                    'penerimaan_inventaris', 'penerimaan_inventaris/*', 'pembayaran_inventaris', 'pembayaran_inventaris/*'
                ]
            ],
            'filterPetugas' => [
                'except' => [
                    'dashboard/*', 'dashboard'
                ]
            ]
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [
        // 'isLoggedIn' => [
        //     'before' => [
        //         'dashboard', // Semua akses ke /dashboard dibatasi oleh filter
        //         'pengguna', // Semua akses ke /pengguna dibatasi oleh filter
        //         'pengguna/*', // Semua akses ke /pengguna/xxx dibatasi oleh filter

        //     ],
        // ],
        /* 'isLoggedIn' => [
            'before' => [
                'pengguna/*' => ['Admin'], // Membatasi akses ke /admin/* hanya untuk admin
                'report/*' => ['Admin'], // Membatasi akses ke /report/* hanya untuk admin
            ],
        ], */];
}
