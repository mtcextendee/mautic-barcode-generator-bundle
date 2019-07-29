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
                    'mautic.plugin.qr_generator.token.replacer'
                ],
            ],
            'mautic.plugin.page.barcode_generator.subscriber' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\EventListener\PageSubscriber::class,
                'arguments' => [
                    'mautic.plugin.barcode_generator.token.replacer',
                    'mautic.lead.model.lead',
                    'mautic.plugin.qr_generator.token.replacer'
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
            'mautic.plugin.qr_generator.token.replacer' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\Token\QrcodeTokenReplacer::class,
                'arguments' => [
                    'router'
                ],
            ],
            'mautic.plugin.qr_generator.token.attributes' => [
                'class'     => \MauticPlugin\MauticBarcodeGeneratorBundle\Token\QrcodeAttribute::class,
                'arguments' => [
                    'mautic.helper.integration'
                ],
            ],
        ],
    ],
    'routes'=>[
        'public' => [
            'mautic_barcode_generator' => [
                'path'       => '/barcode/{token}/{value}/{type}/{options}',
                'controller' => 'MauticBarcodeGeneratorBundle:Public:getBarcode',
                'defaults'   => [
                    'options' => '',
                ],
            ],
            'mautic_qrcode_generator' => [
                'path'       => '/qrcode/{value}/{options}',
                'controller' => 'MauticBarcodeGeneratorBundle:Public:getQrcode',
                'defaults'   => [
                    'options' => '',
                ],
            ],
        ]
    ],
];
