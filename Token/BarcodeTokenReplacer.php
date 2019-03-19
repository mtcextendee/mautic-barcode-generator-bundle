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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class BarcodeTokenReplacer extends TokenReplacer
{
    private $tokenList = [];

    /** @var array */
    private $regex = ['{barcode=(.*?)}', '{barcodePNG=(.*?)}', '{barcodeJPG=(.*?)}', '{barcodeSVG=(.*?)}', '{barcodeHTML=(.*?)}'];

    /** @var  object */
    private $generator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * BarcodeTokenReplacer constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {

        $this->router = $router;
    }

    /**
     * @param string          $content
     * @param array|Lead|null $options
     *
     * @return array
     */
    public function getTokens($content, $options = null)
    {
        foreach ($this->searchTokens($content, $this->regex) as $token => $tokenAttribute) {

            $this->generator  = (new Generator($token))->get();

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
            if ($this->generator instanceof BarcodeGeneratorHTML) {
                $value = $this->generator->getBarcode($value, $this->getBarcodeType($modifier));
            } else {
                $value = '<img src="'.$this->router->generate(
                        'mautic_barcode_generator',
                        [
                            'value' => $value,
                            'token' => substr(strrchr(get_class($this->generator), "\\"), 1),
                            'type' => $this->getBarcodeType($modifier)
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ).'" alt="">';
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
