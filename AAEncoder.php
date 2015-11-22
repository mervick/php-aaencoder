<?php
/**
 * Class AAEncoder
 * @author Andrey Izman <izmanw@gmail.com>
 * @link https://github.com/mervick/php-aaencoder
 * @license MIT
 */

/**
 * Class AAEncoder
 */
class AAEncoder
{
    /**
     * Encode any JavaScript program to Japanese style emoticons (^_^)
     * @param string $js
     * @param int $level [optional]
     * @return string
     */
    public static function encode($js, $level=0)
    {
        $result = "ﾟωﾟﾉ= /｀ｍ´）ﾉ ~┻━┻   //*´∇｀*/ ['_']; o=(ﾟｰﾟ)  =_=3; c=(ﾟΘﾟ) =(ﾟｰﾟ)-(ﾟｰﾟ); " .
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
            "/*´∇｀*/(ﾟДﾟ)[ﾟoﾟ]+ ";

        for ($i = 0, $len = mb_strlen($js); $i < $len; $i++) {
            $code = unpack('N', mb_convert_encoding(mb_substr($js, $i, 1, 'UTF-8'), 'UCS-4BE', 'UTF-8'))[1];
            $text = '(ﾟДﾟ)[ﾟεﾟ]+';
            if ($code <= 127) {
                $text .= preg_replace_callback('/([0-7])/', function($match) use ($level) {
                    $byte = intval($match[1]);
                    return ($level ? self::randomize($byte, $level) : self::$bytes[$byte]) . '+';
                }, decoct($code));
            }
            else {
                $hex = str_split(substr('000' . dechex($code), -4));
                $text .= "(oﾟｰﾟo)+ ";
                for ($i = 0, $len = count($hex); $i < $len; $i++) {
                    $text .= self::$bytes[hexdec($hex[$i])] . '+ ';
                }
            }
            $result .=  $text;

        }
        $result .= "(ﾟДﾟ)[ﾟoﾟ]) (ﾟΘﾟ)) ('_');";
        return $result;
    }

    /**
     * @var array
     */
    protected static $bytes = [
        "(c^_^o)",
        "(ﾟΘﾟ)",
        "((o^_^o) - (ﾟΘﾟ))",
        "(o^_^o)",
        "(ﾟｰﾟ)",
        "((ﾟｰﾟ) + (ﾟΘﾟ))",
        "((o^_^o) +(o^_^o))",
        "((ﾟｰﾟ) + (o^_^o))",
        "((ﾟｰﾟ) + (ﾟｰﾟ))",
        "((ﾟｰﾟ) + (ﾟｰﾟ) + (ﾟΘﾟ))",
        "(ﾟДﾟ) .ﾟωﾟﾉ",
        "(ﾟДﾟ) .ﾟΘﾟﾉ",
        "(ﾟДﾟ) ['c']",
        "(ﾟДﾟ) .ﾟｰﾟﾉ",
        "(ﾟДﾟ) .ﾟДﾟﾉ",
        "(ﾟДﾟ) [ﾟΘﾟ]",
    ];

    /**
     * @param int $byte
     * @param int $level
     * @return string
     */
    protected static function randomize($byte, $level)
    {
        $random = [
            0 => [['+0', '-0'], ['+1', '-1'], ['+3', '-3'], ['+4', '-4']],
            1 => [['+1', '-0'], ['+3', '-1', '-1'], ['+4', '-3']],
            2 => [['+3', '-1'], ['+4', '-3', '+1'], ['+3', '+3', '-4']],
            3 => [['+3', '-0'], ['+4', '-3', '+1', '+1']],
            4 => [['+4', '+0'], ['+1', '+3'], ['+4', '-0']],
            5 => [['+3', '+1', '+1'], ['+4', '+1'], ['+3', '+3', '-1']],
            6 => [['+3', '+3'], ['+4', '+1', '+1'], ['+4', '+3', '-1']],
            7 => [['+3', '+4'], ['+3', '+3', '+1'], ['+4', '+4', '-1']],
        ];
        while ($level--) {
            $byte = preg_replace_callback('/[0-7]/', function($match) use ($random) {
                $numbers = $random[$match[0]][mt_rand(0, count($random[$match[0]]) - 1)];
                shuffle($numbers);
                $byte = ltrim(implode('', $numbers), '+');
                return "($byte)";
            }, $byte);
        }
        $byte = str_replace('+-', '-', $byte);
        return str_replace(array_keys(self::$bytes), self::$bytes, $byte);
    }
}
