# Mautic Barcode Generator Bundle 

Barcode generator for Mautic.

Mautic Extendee family  for Mautic ([https://mtcextendee.com](https://mtcextendee.com/))

### Installation

Installation by command line:

`composer require mtcextendee/mautic-barcode-generator-bundle`

### Usage

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

### Cudos:

- https://github.com/picqer/php-barcode-generator
- https://github.com/mautic/mautic
