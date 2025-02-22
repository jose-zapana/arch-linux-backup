<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        'defaults'       => [
            'title'        => "PC-Hard Technology",
            'titleBefore'  => false, // Coloca el título general antes de los títulos específicos de página
            'description'  => 'PC-Hard Technology ofrece soporte y mantenimiento de ordenadores y laptops, venta de repuestos, computadoras, laptops y accesorios. Servicio especializado en La Molina, Cieneguilla y Manchay.',
            'separator'    => ' | ',
            'keywords'     => ['soporte técnico', 'mantenimiento de laptops', 'venta de ordenadores', 'accesorios de computadoras', 'repuestos', 'La Molina', 'Cieneguilla', 'Manchay'],
            'canonical'    => null, // Usa Url::full() por defecto
            'robots'       => 'all', // Permitir indexar y seguir
        ],
        'webmaster_tags' => [
            'google'    => 'fIRBR-U3jrLhKBW66sqDIWC7UOpz-Ii_9tsOwE7cOQ8',
            'bing'      => '358FBB5D9868E77DCAD29C9728F470E5',
            'alexa'     => null,
            'pinterest' => '124a781bc774341f7b1f5dd41bc87107',
            'yandex'    => '790785e6298d319e',
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title'       => 'PC-Hard Technology',
            'description' => 'Expertos en soporte y mantenimiento de ordenadores y laptops. Encuentra repuestos, computadoras y accesorios en La Molina, Cieneguilla y Manchay.',
            'url'         => null, // Usa Url::current() por defecto
            'type'        => 'website',
            'site_name'   => 'PC-Hard Technology',
            'images'      => [
                'https://pc-hard.com/img/logo-pchard.webp', // Cambia la URL al logo o imagen relevante
            ],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card'        => 'summary_large_image',
            'site'        => '@PC-HardTech', // Cambia a la cuenta de Twitter oficial si tienes una
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title'       => 'PC-Hard Technology',
            'description' => 'Soluciones en soporte y mantenimiento de ordenadores, venta de repuestos, laptops y accesorios. Servicio especializado para La Molina, Cieneguilla y Manchay.',
            'url'         => null, // Usa Url::current() por defecto
            'type'        => 'Organization',
            'images'      => [
                'https://pc-hard.com/img/logo-pchard.webp', // Cambia la URL si tienes imágenes adicionales
            ],
        ],
    ],
];
