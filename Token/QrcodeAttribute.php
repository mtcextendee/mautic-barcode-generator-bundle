<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\Token;

use Endroid\QrCode\QrCode;
use Mautic\CoreBundle\Helper\ColorHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;

class QrcodeAttribute
{
    private $attribute;

    /**
     * @var IntegrationHelper
     */
    private $integrationHelper;

    /**
     * QrcodeAttribute constructor.
     *
     * @param IntegrationHelper $integrationHelper
     */
    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integrationHelper = $integrationHelper;
    }


    /**
     * QrcodeAttribute constructor.
     *
     * @param QrCode $qrCode
     * @param string $modifier
     */
    public function setAttributesFromModifier(QrCode &$qrCode, $modifier = '')
    {
        $this->setDefaultAttributes($qrCode);
        if (empty($modifier)) {
            return;
        }

        $options = explode(',', $modifier);
        foreach ($options as $option) {
            if (strpos($option, '=') !== false) {
                list($key, $value) = explode('=', $option);
                $this->setAttribute($qrCode, $key, $value);
            }
        }
    }

    /**
     * @param QrCode $qrCode
     */
    private function setDefaultAttributes(QrCode &$qrCode)
    {
        $integration = $this->integrationHelper->getIntegrationObject('BarcodeGenerator');
        if ($integration && $integration->getIntegrationSettings()->getIsPublished() === true) {
            $settings = $integration->mergeConfigToFeatureSettings();
            foreach ($settings as $key=>$value) {
                $this->setAttribute($qrCode, $key, $value);
            }
        }
    }

    /**
     * @param QrCode $qrCode
     * @param string $key
     * @param string $value
     */
    private function setAttribute(QrCode &$qrCode, $key, $value)
    {
            switch ($key) {
                case 'size':
                case 'qrcode_size':
                    $qrCode->setSize($value);
                    break;
                case 'margin':
                case 'qrcode_margin':
                    $qrCode->setMargin($value);
                    break;
                case 'error_correction_level':
                case 'qrcode_error_correction_level':
                    $qrCode->setErrorCorrectionLevel($value);
                    break;
                case 'bgcolor':
                case 'qrcode_bgcolor':
                    $qrCode->setBackgroundColor($this->getRGBArray($value));
                    break;
                case 'fgcolor':
                case 'qrcode_fgcolor':
                    $qrCode->setForegroundColor($this->getRGBArray($value));
                    break;
            }
    }

    /**
     * @param string $value
     *
     * @return array
     */
    private function getRGBArray($value)
    {
        $colorHelper = new ColorHelper($this->fixHexColor($value));
        $colorArray = $colorHelper->getColorArray();

        return [
            'r' => $colorArray[0],
            'g' => $colorArray[1],
            'b' => $colorArray[2],
            'a' => 0,
        ];
    }

    /**
     * @param string $color
     *
     * @return string
     */
    private function fixHexColor($color)
    {
        if (!$this->startWith($color, '#')) {
            return '#'.$color;
        }

        return $color;
    }

    /**
     * @param string $string
     * @param string $prefix
     *
     * @return bool
     */
    private function startWith($string, $prefix)
    {
        return substr($string, 0, strlen($prefix)) == $prefix;
    }

}
