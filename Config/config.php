<?php

return [
    'name'        => 'Barcode Generator',
    'description' => 'Barcode Generator for Mautic',
    'author'      => 'mtcextendee.com',
    'version'     => '1.0.0',
    'services' => [
        'events' => [
            'mautic.plugin.email.barcode_generator.subscriber' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\EventListener\EmailSubscriber::class,
                'arguments' => [
                    'mautic.plugin.barcode_generator.token.replacer',
                ],
            ],
            'mautic.plugin.page.barcode_generator.subscriber' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\EventListener\PageSubscriber::class,
                'arguments' => [
                    'mautic.plugin.barcode_generator.token.replacer',
                    'mautic.lead.model.lead',
                ],
            ],
        ],
        'other' => [
            'mautic.plugin.barcode_generator.token.replacer' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\Token\BarcodeTokenReplacer::class,
                'arguments' => [
                    'router'
                ],
            ],
        ],
    ],
    'routes'=>[
        'public' => [
            'mautic_barcode_generator' => [
                'path'       => '/barcode/{token}/{value}/{type}',
                'controller' => 'MauticBarcodeGeneratorBundle:Public:get',
            ],
        ]
    ],
];
