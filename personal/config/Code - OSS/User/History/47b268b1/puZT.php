<?php
/**
 * Configuración de SEO para PC-Hard Technology
 * @see https://github.com/artesaos/seotools
 */

 return [
    'meta' => [
        /*
         * Configuraciones predeterminadas del generador de metaetiquetas.
         */
        'defaults'       => [
            'title'        => false, // Título predeterminado
            'titleBefore'  => true, // Coloca el título predeterminado antes del título de la página
            'description'  => false, // Descripción principal
            'separator'    => ' | ',
            'keywords'     => ['hardware', 'computadoras', 'tecnología', 'PC', 'ensamblaje de ordenadores', 'PC-Hard Technology'],
            'canonical'    => 'current', // Usa la URL actual
            'robots'       => 'index, follow', // Indica que las páginas sean indexadas y seguidas
        ],
        /*
         * Etiquetas de verificación de webmaster (opcional).
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false, // Evitar agregar la clase notranslate
    ],
    'opengraph' => [
        /*
         * Configuraciones predeterminadas del generador de OpenGraph.
         */
        'defaults' => [
            'title'       => 'PC-Hard Technology', // Título predeterminado para redes sociales
            'description' => 'En PC-Hard Technology ofrecemos productos de calidad en hardware, ensamblaje y soluciones tecnológicas personalizadas.',
            'url'         => 'https://pc-hard.com', // URL base
            'type'        => 'website',
            'site_name'   => 'PC-Hard Technology',
            'images'      => ['https://pc-hard.com/img/social-share.jpg'], // URL de imagen compartida
        ],
    ],
    'twitter' => [
        /*
         * Configuraciones predeterminadas para Twitter Cards.
         */
        'defaults' => [
            'card'        => 'summary_large_image', // Estilo de tarjeta
            'site'        => '@PC_HardTech', // Cuenta de Twitter (si aplica)
        ],
    ],
    'json-ld' => [
        /*
         * Configuraciones predeterminadas para JSON-LD (SEO técnico).
         */
        'defaults' => [
            'title'       => 'PC-Hard Technology',
            'description' => 'Tu aliado en tecnología y hardware. Descubre nuestros productos y servicios para potenciar tu entorno digital.',
            'url'         => 'https://pc-hard.com',
            'type'        => 'Organization', // Tipo de entidad
            'images'      => ['https://pc-hard.com/img/social-share.jpg'], // Imagen destacada
        ],
    ],
];
