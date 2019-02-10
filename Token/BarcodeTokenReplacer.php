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

use Mautic\LeadBundle\Entity\Lead;
use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;

class BarcodeTokenReplacer extends TokenReplacer
{
    private $tokenList = [];

    /** @var array */
    private $regex = ['{barcode=(.*?)}', '{barcodePNG=(.*?)}', '{barcodeJPG=(.*?)}', '{barcodeSVG=(.*?)}', '{barcodeHTML=(.*?)}'];

    /** @var  object */
    private $generator;

    /**
     * @param string          $content
     * @param array|Lead|null $options
     *
     * @return array
     */
    public function getTokens($content, $options = null)
    {
        foreach ($this->searchTokens($content, $this->regex) as $token => $tokenAttribute) {
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

            $this->tokenList[$token] = $this->getBarcodeTokenValue(
                $options,
                $tokenAttribute->getAlias(),
                $tokenAttribute->getModifier()
            );
        }

        return $this->tokenList;
    }

    /**
     * @param array  $fields
     * @param string $alias
     * @param string $modifier
     *
     * @return mixed|string
     */
    private function getBarcodeTokenValue(array $fields, $alias, $modifier)
    {
        $value = '';
        if (isset($fields[$alias])) {
            $value = $fields[$alias];
        } elseif (isset($fields['companies'][0][$alias])) {
            $value = $fields['companies'][0][$alias];
        }

        if ($value && is_object($this->generator)) {
            if ($this->generator instanceof BarcodeGeneratorPNG) {
                $value = '<img src="data:image/png;base64,'.base64_encode(
                        $this->generator->getBarcode($value, $this->getBarcodeType($modifier))
                    ).'">';
            } elseif ($this->generator instanceof BarcodeGeneratorJPG) {
                $value = '<img src="data:image/jpg;base64,'.base64_encode(
                        $this->generator->getBarcode($value, $this->getBarcodeType($modifier))
                    ).'">';
            } else {
                $value = $this->generator->getBarcode($value, $this->getBarcodeType($modifier));
            }
        }

       return $value;
    }

    /**     *
     * Return type of barcode, default TYPE_CODE_128
     *
     * @param $type
     *
     * @return string
     */
    private function getBarcodeType($type = null){
        $class = BarcodeGenerator::class;
        return $type && defined($class.'::'.$type) ?  constant($class.'::'.$type) : BarcodeGenerator::TYPE_CODE_128;
    }

    /**
     * @return array
     */
    public function getRegex()
    {
        return $this->regex;
    }
}
