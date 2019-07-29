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

use Mautic\LeadBundle\Entity\Lead;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class QrcodeTokenReplacer extends TokenReplacer
{
    private $tokenList = [];

    /** @var array */
    private $regex = ['{qrcode=(.*?)}'];

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
            $this->tokenList[$token] = $this->getQrTokenValue(
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
    private function getQrTokenValue(array $fields, $alias, $modifier)
    {
        $value = '';

        if (isset($fields[$alias])) {
            $value = $fields[$alias];
        } elseif (isset($fields['companies'][0][$alias])) {
            $value = $fields['companies'][0][$alias];
        }
        if ($value !== '') {
                $value = '<img src="'.$this->router->generate(
                        'mautic_qrcode_generator',
                        [
                            'value' => $value,
                            'options' => $modifier,
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ).'" alt="">';
            }

       return $value;
    }

    /**
     * @return array
     */
    public function getRegex()
    {
        return $this->regex;
    }
}
