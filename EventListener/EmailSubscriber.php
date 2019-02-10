<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\EventListener;


use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event as Events;
use Mautic\CoreBundle\Exception as MauticException;
use MauticPlugin\MauticBarcodeGeneratorBundle\Token\BarcodeTokenReplacer;

/**
 * Class EmailSubscriber.
 */
class EmailSubscriber extends CommonSubscriber
{

    /**
     * @var BarcodeTokenReplacer
     */
    private $barcodeTokenReplacer;

    public function __construct(BarcodeTokenReplacer $barcodeTokenReplacer)
    {

        $this->barcodeTokenReplacer = $barcodeTokenReplacer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EmailEvents::EMAIL_ON_SEND => ['onEmailGenerate', 0],
            EmailEvents::EMAIL_ON_DISPLAY => ['onEmailGenerate', 0],
        ];
    }

    /**
     * Search and replace tokens with content
     *
     * @param EmailSendEvent $event
     */
    public function onEmailGenerate(Events\EmailSendEvent $event)
    {
        $content = $event->getContent();
        $content = $this->barcodeTokenReplacer->replaceTokens($content, $event->getLead());
        $event->setContent($content);
    }
}