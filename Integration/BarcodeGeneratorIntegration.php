<?php


/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\Integration;
use Endroid\QrCode\ErrorCorrectionLevel;
use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;

class BarcodeGeneratorIntegration extends AbstractIntegration
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'BarcodeGenerator';
    }

    public function getIcon()
    {
        return 'plugins/MauticBarcodeGeneratorBundle/Assets/img/logo.png';
    }

    /**
     * @return array
     */
    public function getFormSettings()
    {
        return [
            'requires_callback'      => false,
            'requires_authorization' => false,
        ];
    }
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getAuthenticationType()
    {
        return 'none';
    }

    /**
     * @param \Mautic\PluginBundle\Integration\Form|FormBuilder $builder
     * @param array                                             $data
     * @param string                                            $formArea
     */
    public function appendToForm(&$builder, $data, $formArea)
    {
        if ($formArea == 'features') {


            $builder->add(
                'qrcode_size',
                NumberType::class,
                [
                    'label'      => 'mautic.plugin.barcode.form.size',
                    'label_attr' => ['class' => 'control-label'],
                    'attr'       => [
                        'class'        => 'form-control',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );

            $builder->add(
                'qrcode_margin',
                NumberType::class,
                [
                    'label'      => 'mautic.plugin.barcode.form.margin',
                    'label_attr' => ['class' => 'control-label'],
                    'attr'       => [
                        'class'        => 'form-control',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );

            $builder->add(
                'qrcode_fgcolor',
                TextType::class,
                [
                    'label'      => 'mautic.plugin.barcode.form.fgcolor',
                    'label_attr' => ['class' => 'control-label'],
                    'attr'       => [
                        'class'        => 'form-control',
                        'data-toggle' => 'color',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );

            $builder->add(
                'qrcode_bgcolor',
                TextType::class,
                [
                    'label'      => 'mautic.plugin.barcode.form.bgcolor',
                    'label_attr' => ['class' => 'control-label'],
                    'attr'       => [
                        'class'        => 'form-control',
                        'data-toggle' => 'color',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );

            $builder->add('qrcode_error_correction_level', 'choice', [
                'choices'  => [
                    ErrorCorrectionLevel::LOW=>ErrorCorrectionLevel::LOW,
                    ErrorCorrectionLevel::QUARTILE=>ErrorCorrectionLevel::QUARTILE,
                    ErrorCorrectionLevel::MEDIUM=>ErrorCorrectionLevel::MEDIUM,
                    ErrorCorrectionLevel::HIGH=>ErrorCorrectionLevel::HIGH,
                ],
                'label'    => 'mautic.plugin.barcode.form.error_correction_level',
                'required' => true,
                'empty_value'=>false,
                'attr'     => [
                ],
            ]);


        }
    }
}
