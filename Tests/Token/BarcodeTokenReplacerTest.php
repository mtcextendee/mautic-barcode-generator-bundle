<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticBarcodeGeneratorBundle\Tests\Token;


use MauticPlugin\MauticBarcodeGeneratorBundle\Token\BarcodeTokenReplacer;

class BarcodeTokenReplacerTest extends \PHPUnit_Framework_TestCase
{
    private $lead = [
        'firstname' => 'Bob',
        'lastname'  => 'Smith',
        'barcodefield'  => 123,
        'country'   => '',
        'web'       => 'https://mautic.org',
        'date'      => '2000-05-05 12:45:50',
        'companies' => [
            [
                'companyzip' => '77008',
            ],
        ],
    ];

    private $content = 'custom content with {barcode=barcodefield}';

    private $regex;

    private $barcodeTokenReplacer;

    public function setUp()
    {
        $this->barcodeTokenReplacer = new BarcodeTokenReplacer();
        $this->regex                = $this->barcodeTokenReplacer->getRegex();
        parent::setUp();
    }

    public function testSearchTokens()
    {
        $tokens = $this->barcodeTokenReplacer->searchTokens($this->content, $this->regex);
        $this->assertCount(1, $tokens);
    }

    public function testGetTokens()
    {
        $tokens = $this->barcodeTokenReplacer->getTokens($this->content, $this->lead);
        $this->assertCount(1, $tokens);
    }

    public function testReplaceTokens()
    {
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertNotEquals($this->content, $content);
        $this->assertContains('<img', $content);
    }

    public function testReplaceEmptyValueTokens()
    {
        $content = 'custom content with {barcode=country}';
        $content = $this->barcodeTokenReplacer->replaceTokens($content, $this->lead);
        $this->assertEquals('custom content with ', $content);
    }

    public function testReplaceTokensDefaultPNG()
    {
        $this->content = 'custom content with {barcodePNG=barcodefield}';
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertContains('image/png', $content);
    }

    public function testReplaceTokensPNG()
    {
        $this->content = 'custom content with {barcodePNG=barcodefield}';
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertContains('image/png', $content);
    }

    public function testReplaceTokensJPG()
    {
        $this->content = 'custom content with {barcodeJPG=barcodefield}';
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertContains('image/jpg', $content);
    }

    public function testReplaceTokensSVG()
    {
        $this->content = 'custom content with {barcodeSVG=barcodefield}';
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertContains('<svg', $content);
    }

    public function testReplaceTokensHTML()
    {
        $this->content = 'custom content with {barcodeHTML=barcodefield}';
        $content = $this->barcodeTokenReplacer->replaceTokens($this->content, $this->lead);
        $this->assertContains('<div', $content);
    }
}
