<?php
/**
 * Class AAEncoder
 * @author Andrey Izman <izmanw@gmail.com>
 * @link https://github.com/mervick/php-aaencoder
 * @license MIT
 */

/**
 * Class AADecoder
 */
class AADecoder
{
    const BEGIN_CODE = "ﾟωﾟﾉ= /｀ｍ´）ﾉ ~┻━┻   //*´∇｀*/ ['_']; o=(ﾟｰﾟ)  =_=3; c=(ﾟΘﾟ) =(ﾟｰﾟ)-(ﾟｰﾟ); " .
    "(ﾟДﾟ) =(ﾟΘﾟ)= (o^_^o)/ (o^_^o);" .
    "(ﾟДﾟ)={ﾟΘﾟ: '_' ,ﾟωﾟﾉ : ((ﾟωﾟﾉ==3) +'_') [ﾟΘﾟ] " .
    ",ﾟｰﾟﾉ :(ﾟωﾟﾉ+ '_')[o^_^o -(ﾟΘﾟ)] " .
    ",ﾟДﾟﾉ:((ﾟｰﾟ==3) +'_')[ﾟｰﾟ] }; (ﾟДﾟ) [ﾟΘﾟ] =((ﾟωﾟﾉ==3) +'_') [c^_^o];" .
    "(ﾟДﾟ) ['c'] = ((ﾟДﾟ)+'_') [ (ﾟｰﾟ)+(ﾟｰﾟ)-(ﾟΘﾟ) ];" .
    "(ﾟДﾟ) ['o'] = ((ﾟДﾟ)+'_') [ﾟΘﾟ];" .
    "(ﾟoﾟ)=(ﾟДﾟ) ['c']+(ﾟДﾟ) ['o']+(ﾟωﾟﾉ +'_')[ﾟΘﾟ]+ ((ﾟωﾟﾉ==3) +'_') [ﾟｰﾟ] + " .
    "((ﾟДﾟ) +'_') [(ﾟｰﾟ)+(ﾟｰﾟ)]+ ((ﾟｰﾟ==3) +'_') [ﾟΘﾟ]+" .
    "((ﾟｰﾟ==3) +'_') [(ﾟｰﾟ) - (ﾟΘﾟ)]+(ﾟДﾟ) ['c']+" .
    "((ﾟДﾟ)+'_') [(ﾟｰﾟ)+(ﾟｰﾟ)]+ (ﾟДﾟ) ['o']+" .
    "((ﾟｰﾟ==3) +'_') [ﾟΘﾟ];(ﾟДﾟ) ['_'] =(o^_^o) [ﾟoﾟ] [ﾟoﾟ];" .
    "(ﾟεﾟ)=((ﾟｰﾟ==3) +'_') [ﾟΘﾟ]+ (ﾟДﾟ) .ﾟДﾟﾉ+" .
    "((ﾟДﾟ)+'_') [(ﾟｰﾟ) + (ﾟｰﾟ)]+((ﾟｰﾟ==3) +'_') [o^_^o -ﾟΘﾟ]+" .
    "((ﾟｰﾟ==3) +'_') [ﾟΘﾟ]+ (ﾟωﾟﾉ +'_') [ﾟΘﾟ]; " .
    "(ﾟｰﾟ)+=(ﾟΘﾟ); (ﾟДﾟ)[ﾟεﾟ]='\\\\'; " .
    "(ﾟДﾟ).ﾟΘﾟﾉ=(ﾟДﾟ+ ﾟｰﾟ)[o^_^o -(ﾟΘﾟ)];" .
    "(oﾟｰﾟo)=(ﾟωﾟﾉ +'_')[c^_^o];" .
    "(ﾟДﾟ) [ﾟoﾟ]='\\\"';" .
    "(ﾟДﾟ) ['_'] ( (ﾟДﾟ) ['_'] (ﾟεﾟ+" .
    "(ﾟДﾟ)[ﾟoﾟ]+ ";

    const END_CODE = "(ﾟДﾟ)[ﾟoﾟ]) (ﾟΘﾟ)) ('_');";


    /**
     * Decode encoded-as-aaencode JavaScript code.
     * @param string $js
     * @return string
     */
    public static function decode($js)
    {
        if (self::hasAAEncoded($js, $start, $end)) {
            $decoded = self::deobfuscate(mb_substr($js, $pos = $start + mb_strlen(self::BEGIN_CODE, 'UTF-8'), $end - $pos, 'UTF-8')) . ';';
            return mb_substr($js, 0, $start, 'UTF-8') . $decoded .
                self::decode(mb_substr($js, $end + mb_strlen(self::END_CODE, 'UTF-8') + 1, null, 'UTF-8'));
        }
        return $js;
    }

    /**
     * @param string $js
     * @return string
     */
    protected static function deobfuscate($js)
    {
        $bytes = [
            5 => "((ﾟｰﾟ) + (ﾟΘﾟ))" ,
            6 => "((o^_^o) +(o^_^o))" ,
            7 => "((ﾟｰﾟ) + (o^_^o))" ,
            8 => "((ﾟｰﾟ) + (ﾟｰﾟ))" ,
            9 => "((ﾟｰﾟ) + (ﾟｰﾟ) + (ﾟΘﾟ))" ,
            10 => "(ﾟДﾟ) .ﾟωﾟﾉ" ,
            11 => "(ﾟДﾟ) .ﾟΘﾟﾉ" ,
            12 => "(ﾟДﾟ) ['c']" ,
            13 => "(ﾟДﾟ) .ﾟｰﾟﾉ" ,
            14 => "(ﾟДﾟ) .ﾟДﾟﾉ" ,
            15 => "(ﾟДﾟ) [ﾟΘﾟ]",
            4 => "(ﾟｰﾟ)" ,
            2 => "((o^_^o) - (ﾟΘﾟ))" ,
            3 => "(o^_^o)" ,
            1 => "(ﾟΘﾟ)" ,
            0 => "(c^_^o)" ,
        ];
        $chars = [];
        $hex = "(oﾟｰﾟo)+ ";
        $hexLen = mb_strlen($hex, 'UTF-8');
        $convert = function ($block, $func) use ($bytes) {
            foreach ($bytes as $byte => $search) {
                $block = implode($byte, mb_split(preg_quote($search), $block));
            }
            $split = [];
            foreach (explode('+', trim($block, '+ ')) as $num) {
                $split[] = $func(intval(trim($num)));
            }
            return implode('', $split);
        };

        foreach (mb_split(preg_quote("(ﾟДﾟ)[ﾟεﾟ]+"), $js) as $block) {
            if ($block === '') continue;
            if (mb_substr($block, 0, $hexLen, 'UTF-8') === $hex) {
                $code = hexdec($convert(mb_substr($block, $hexLen, null, 'UTF-8'), 'dechex'));
            }
            else {
                $code = octdec($convert($block, 'decoct'));
            }
            $chars[] = mb_convert_encoding('&#' . intval($code) . ';', 'UTF-8', 'HTML-ENTITIES');
        }
        return implode('', $chars);
    }

    /**
     * Detect aaencoded JavaScript code.
     * @param string $js
     * @param null|int $start
     * @param null|int $end
     * @return bool
     */
    public static function hasAAEncoded($js, &$start=null, &$end=null)
    {
        return
            ($start = mb_strpos($js, self::BEGIN_CODE, null, 'UTF-8')) !== false &&
            ($end = mb_strpos($js, self::END_CODE, $start + mb_strlen(self::BEGIN_CODE, 'UTF-8'), 'UTF-8')) !== false;
    }
}