<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\Token;

use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;

class Generator
{

    private $generator;

    public function __construct($token)
    {
        switch ($token) {
            case $token && (FALSE !== strpos($token, 'JPG')):
                $this->generator = new BarcodeGeneratorJPG();
                break;
            case $token && (FALSE !== strpos($token, 'SVG')):
                $this->generator = new BarcodeGeneratorSVG();
                break;
            case $token && (FALSE !== strpos($token, 'HTML')):
                $this->generator = new BarcodeGeneratorHTML();
                break;
            case $token && (FALSE !== strpos($token, 'PNG')):
            default:
                $this->generator = new BarcodeGeneratorPNG();
                break;
        }
    }

    /**
     * @return BarcodeGenerator|BarcodeGeneratorPNG|BarcodeGeneratorJPG|BarcodeGeneratorSVG\
     */
    public function get()
    {
        return $this->generator;
    }


}
