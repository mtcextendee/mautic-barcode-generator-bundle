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
use Mautic\LeadBundle\Model\LeadModel;
use Mautic\PageBundle\Event\PageDisplayEvent;
use Mautic\PageBundle\PageEvents;
use MauticPlugin\MauticBarcodeGeneratorBundle\Token\BarcodeTokenReplacer;
use MauticPlugin\MauticBarcodeGeneratorBundle\Token\QrcodeTokenReplacer;

/**
 * Class PageSubscriber.
 */
class PageSubscriber extends CommonSubscriber
{

    /**
     * @var LeadModel $leadModel
     */
    protected $leadModel;

    /**
     * @var BarcodeTokenReplacer
     */
    private $barcodeTokenReplacer;

    /**
     * @var QrcodeTokenReplacer
     */
    private $qrcodeTokenReplacer;


    /**
     * EmailSubscriber constructor.
     *
     * @param BarcodeTokenReplacer $barcodeTokenReplacer
     * @param LeadModel            $leadModel
     * @param QrcodeTokenReplacer  $qrcodeTokenReplacer
     */
    public function __construct(BarcodeTokenReplacer $barcodeTokenReplacer, LeadModel $leadModel, QrcodeTokenReplacer $qrcodeTokenReplacer)
    {
        $this->leadModel = $leadModel;
        $this->barcodeTokenReplacer = $barcodeTokenReplacer;
        $this->qrcodeTokenReplacer = $qrcodeTokenReplacer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            PageEvents::PAGE_ON_DISPLAY => ['onPageDisplay', 0],
        ];
    }

    /**
     * @param PageDisplayEvent $event
     */
    public function onPageDisplay(PageDisplayEvent $event)
    {

        $content = $event->getContent();
        $lead    = ($this->security->isAnonymous()) ? $this->leadModel->getCurrentLead() : null;
        if($lead && $lead->getId()){
            $content = $this->barcodeTokenReplacer->replaceTokens($content, $lead->getProfileFields());
            $content = $this->qrcodeTokenReplacer->replaceTokens($content, $lead->getProfileFields());
        }
        $event->setContent($content);
    }
}
