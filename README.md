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
// Also, you can customize encoding level, may be >= 0, default 0. 
// Be careful, the greater the level of encryption the larger output file.
// It is not recommended to use more than 3
echo AAEncoder::encode(file_get_contents('/path/to/file.js'), 2);

// aadecode:
echo AADecoder::decode(file_get_contents('/path/to/encoded.js'));
```

## Requirements
PHP >= 5.4

## License
MIT
