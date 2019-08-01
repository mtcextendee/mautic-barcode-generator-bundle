# Mautic Barcode and QR code Generator Bundle 

Barcode and QRcode generator for Mautic. Barcode and QR code can be used also in Badge Bundle for Mautic https://github.com/mtcextendee/mautic-badge-generator-bundle

Mautic Extendee family  for Mautic ([https://mtcextendee.com](https://mtcextendee.com/))

### Installation

Installation by command line:

`composer require mtcextendee/mautic-barcode-generator-bundle`

### Usage for barcode

Use  `{barcode=custom_field_alias}` token in page or email builder. 

**Barcode examples**  
  
**Output types (default PNG image):**  

    {barcode=custom_contact_field}
    
    {barcodePNG=custom_contact_field}      

    {barcodeJPG=custom_contact_field}
    
    {barcodeSVG=custom_contact_field}
    
    {barcodeHTML=custom_contact_field} 
  
**Barcode types (default TYPE_CODE_128):**  
  
    {barcode=custom_contact_field|TYPE_CODE_39}
    
    {barcode=custom_contact_field|TYPE_EAN_5}

### Accepted types

-   TYPE_CODE_39
-   TYPE_CODE_39_CHECKSUM
-   TYPE_CODE_39E
-   TYPE_CODE_39E_CHECKSUM
-   TYPE_CODE_93
-   TYPE_STANDARD_2_5
-   TYPE_STANDARD_2_5_CHECKSUM
-   TYPE_INTERLEAVED_2_5
-   TYPE_INTERLEAVED_2_5_CHECKSUM
-   TYPE_CODE_128
-   TYPE_CODE_128_A
-   TYPE_CODE_128_B
-   TYPE_CODE_128_C
-   TYPE_EAN_2
-   TYPE_EAN_5
-   TYPE_EAN_8
-   TYPE_EAN_13
-   TYPE_UPC_A
-   TYPE_UPC_E
-   TYPE_MSI
-   TYPE_MSI_CHECKSUM
-   TYPE_POSTNET
-   TYPE_PLANET
-   TYPE_RMS4CC
-   TYPE_KIX
-   TYPE_IMB
-   TYPE_CODABAR
-   TYPE_CODE_11
-   TYPE_PHARMA_CODE
-   TYPE_PHARMA_CODE_TWO_TRACKS


#### Input in email/page builder

<img src="https://user-images.githubusercontent.com/462477/52535015-47aea080-2d49-11e9-983f-e9e6827204ac.png" alt="" width="250px">

#### Output

<img src="https://user-images.githubusercontent.com/462477/52535023-63b24200-2d49-11e9-8244-a6078bf2fcc6.png" alt="" width="250px">

### Usage for QR code

You can setup basic settings in Plugins > Barcode Generator. 

<img src="https://user-images.githubusercontent.com/462477/62292604-0f219100-b467-11e9-95ca-0869656e52b3.png" width="250px" >

Then you can use `{qrcode=custom_field_alias}` token in page or email builder. 

These settings can be overwrite also by tokens modifier::

`{qrcode=custom_contact_field|size=30,margin=10,fgcolor=000000,bgcolor=#FFFFF,error_correction_level=low}`

### Unit tests

```
phpunit --bootstrap ../vendor/autoload.php --configuration ../app/phpunit.xml.dist -d memory_limit=2048M --filter BarcodeTokenReplacerTest
```

### Cudos:

- https://github.com/picqer/php-barcode-generator
- https://github.com/endroid/qr-code
- https://github.com/mautic/mautic
