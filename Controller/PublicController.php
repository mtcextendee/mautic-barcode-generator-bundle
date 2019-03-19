<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\Controller;

use Mautic\CoreBundle\Controller\CommonController;
use MauticPlugin\MauticBarcodeGeneratorBundle\Token\Generator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PublicController extends CommonController
{
    /**
     * @param $token
     * @param $value
     *
     * @return Response
     */
    public function getAction($token, $value, $type)
    {
        $barcodeGenerator = (new Generator($token))->get();
        $barcode = $barcodeGenerator->getBarcode($value, $type);
        $img = $token.'.png';

        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent($barcode);
        return $response;
    }
}
