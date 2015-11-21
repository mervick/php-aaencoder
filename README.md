# PHP AAEncoder and AADecoder

`AAEncoder` - Encode any JavaScript program to [Japanese style emoticons](http://utf-8.jp/public/aaencode.html) (^\_^).  
`AADecoder` - Decode encoded as aaencode JavaScript program. (ﾟДﾟ) ['\_']

## Installation via Composer
```sh
composer require "mervick/aaencoder"
```

## Usage
```php
// aaencode:
echo AAEncoder::encode(file_get_contents('/path/to/file.js'));

// aadecode:
echo AADecoder::decode(file_get_contents('/path/to/encoded.js'));
```

## Requirements
PHP >= 5.4

## License
MIT
