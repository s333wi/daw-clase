<?php

namespace App\Libraries;

use GdImage;

/**
 * Display captcha
 *
 */

class Text2Image
{
    /**
     * font TTF file
     *
     * @var string | /public/fonts/monofont.ttf
     */
    private string $font;
    /**
     * text to show into image. Generated by captcha function or set by user
     *
     * @var string
     */
    private string $text;
    /**
     * letters used by generator for captcha function
     *
     * @var string
     */
    private string $letters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //'23456789bcdfghjkmnpqrstvwxyz';
    /**
     * Text length, it can be set to generate random text or is set automatically
     * if user set a text
     *
     * @var int | 6
     */
    private int $length;
    /**
     * textColor value can be CSS codified shortly or extende #ccc or #cccccc
     *
     * @var string | 162453
     */
    private string $textColor;
    /**
     * backColor value can be CSS codified shortly or extende #ccc or #cccccc
     *
     * @var string | 395786
     */
    private string $backColor;
    /**
     * noiceColor value can be CSS codified shortly or extende #ccc or #cccccc
     *
     * @var string | 162453
     */
    private string $noiceColor;

    /**
     * imgWidth
     *
     * @var int | 180
     */
    private int $imgWidth;
    /**
     * imgHeight
     *
     * @var int | 40
     */
    private int $imgHeight;
    /**
     * noiceLines
     *
     * @var int | 25
     */
    private int $noiceLines;
    /**
     * noiceDots
     *
     * @var int | 25
     */
    private int $noiceDots;
    /**
     * expiration
     *
     * @var int | 15 * MINUTE
     */
    private int $expiration; //CAPTCHA file expiration
    /**
     * Image generated by library and base64 encoded
     *
     * @var string
     */
    private string $blob;


    /**
     * toJSON
     * returns a JSON object with image base64 codified and text included into image
     *
     * @return string
     */
    public function toJSON()
    {
        return json_encode(array('text' => $this->text, 'image_base64' => $this->blob));
    }

    /**
     * toImg64
     * returns base64 image generated by library
     *
     * @return string
     */
    public function toImg64()
    {
        return $this->blob;
    }

    /**
     * html
     * returns  html IMG tag with image src data codified
     *
     * @return string
     */
    public function html()
    {
        return '<img src="data:image/png;base64,' . $this->blob . '" />';
    }

    /**
     * saveToFile
     *
     * @param  string $publicImageFolder                subfolder of public CI4 folder to save generated file
     * @param  string $name | intval(microtime(true))   image filename to store generated image. Default is microtime
     * @param  string $clearOld | false                 Indicates function to clear folder for old generated values, if name uses microtime value
     * @return string                                   JSON encoded with text, relative path and image name generated by function
     */
    public function saveToFile($publicImageFolder, $name = null, $clearOld = false)
    {
        $relativePath = ROOTPATH . '/public/' . $publicImageFolder . "/";

        $now = intval(microtime(true));

        //TODO: remove old files
        if ($clearOld) {
            $img_path = realpath($relativePath);
            $current_dir = @opendir($img_path);
            while ($filename = @readdir($current_dir)) {
                if (
                    in_array(substr($filename, -4), array('.jpg', '.png'))
                    && (str_replace(array('.jpg', '.png'), '', $filename) + $this->expiration) < $now
                ) {
                    @unlink($img_path . '/' . $filename);
                }
            }

            @closedir($current_dir);
        }

        $filename = $name ?? $now . ".jpg";
        $filepath = realpath($relativePath) . "/" . $filename;

        $img = imagecreatefromstring(base64_decode($this->blob));

        if ($img !== false && imagejpeg($img, $filepath, 90)) {/*save image as JPG*/
            return json_encode(array('text' => $this->text, 'path' => $relativePath, 'imagename' => $filename));
        } else
            return json_encode(array('text' => $this->text, 'path' => $relativePath, 'imagename' => 'ERROR not saved'));
    }

    /**
     * __construct
     * Construct object with default values, image default is a black square 10x10
     *
     * @param  array $config
     * @return void
     */
    public function __construct($config = null)
    {
        $this->blob = 'iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAQAAAAngNWGAAAAF0lEQVR42mNk+M9AFGAcVTiqcFQhCAAAf0sUAaSRMCEAAAAASUVORK5CYII=';
        if (isset($config)) $this->setConfig($config);
        else $this->setConfig(null);
    }


    /**
     * setConfig
     * Function permit to config library values, param is a associative array
     * if a value is not set or empty i uses a default value
     *
     * @param  array $config
     * @return object           returns object instance to permit concate calls
     */
    public function setConfig($config)
    {
        $this->setLength($config['length'] ?? $this->length ?? 6);
        $this->setText($config['text'] ?? $this->text ?? $this->random());

        /* font folder */
        $this->font = $config['font'] ?? $this->font ?? realpath(ROOTPATH . "/public/fonts/monofont.ttf");
        $this->textColor = $config['textColor'] ?? $this->textColor ?? "162453";
        $this->backColor = $config['backColor'] ?? $this->backColor ?? "#395786";
        $this->noiceColor = $config['noiceColor'] ?? $this->noiceColor ?? "162453";
        $this->imgWidth = $config['imgWidth'] ?? $this->imgWidth ?? 180;
        $this->imgHeight = $config['imgHeight'] ?? $this->imgHeight ?? 40;
        $this->noiceLines = $config['noiceLines'] ?? $this->noiceLines ?? 25;
        $this->noiceDots = $config['noiceDots'] ?? $this->noiceDots ?? 25;
        $this->expiration = $config['expiration'] ?? $this->expiration ?? 15 * MINUTE;

        return $this;
    }

    /**
     * textToImage
     * This function generates an image with text value inside
     *
     * @param  string $textToShow   string text to show into image
     * @return object               return object instance to permit concate calls
     */
    public function textToImage($textToShow = null)
    {
        $this->text = $textToShow ?? $this->text;
        $fontSize = $this->imgHeight * 0.75;
        $text = $textToShow ?? $this->text;

        $textColor = $this->hexToRGB($this->textColor);

        $im = imagecreatetruecolor($this->imgWidth, $this->imgHeight);
        $textColor = imagecolorallocate($im, $textColor['r'], $textColor['g'], $textColor['b']);

        $backgroundColor = $this->hexToRGB($this->backColor);
        $backgroundColor = imagecolorallocate($im, $backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b']);

        imagefill($im, 0, 0, $backgroundColor);
        list($x, $y) = $this->ImageTTFCenter($im, $this->text, $this->font, $this->fontSize);
        imagettftext($im, $fontSize, 0, 10, $y + 10, $textColor, $this->font, $text);

        ob_start();
        imagejpeg($im, NULL, 90);  /* save image to buffer */
        $this->blob = base64_encode(ob_get_contents()); // read from buffer and convert
        ob_end_clean(); // delete buffer

        // $this->img=$im;

        imagedestroy($im);

        return $this;
    }

    /**
     * captcha
     * This function generates a captcha, with noise (lines & points) and
     * text value that can be generated randomly or set by user
     *
     * @return object   return object instance to permit concate calls
     */
    public function captcha()
    {
        $im = imagecreatetruecolor($this->imgWidth, $this->imgHeight);

        $fontSize = $this->imgHeight * 0.75;

        $backgroundColor = $this->hexToRGB($this->backColor);
        $backgroundColor = imagecolorallocate($im, $backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b']);

        $textColor = $this->hexToRGB($this->textColor);
        $textColor = imagecolorallocate($im, $textColor['r'], $textColor['g'], $textColor['b']);

        imagefill($im, 0, 0, $backgroundColor);

        $im = $this->addNoise($im);

        list($x, $y) = $this->ImageTTFCenter($im, $this->text, $this->font, $this->fontSize);

        for ($i = 0; $i < strlen($this->text); $i++) {
            $pos = mt_rand(-45, 45);
            imagettftext($im, $fontSize, $pos, 10 + ($i * $fontSize), $y + 10, $textColor, $this->font, $this->text[$i]);
        }

        ob_start();
        imagejpeg($im, NULL, 90);/* save image to buffer */
        $this->blob = base64_encode(ob_get_contents()); // read from buffer and convert
        ob_end_clean(); // delete buffer

        imagedestroy($im);

        return $this;
    }
    /**
     * Setters and getters section
     */


    /**
     * setLetters
     * Set letters availables to generate captcha
     *
     * @param  string $value
     * @return void
     */
    protected function setLetters($value)
    {
        $this->letters = $value;
        $this->text = $this->random();
    }

    /**
     * getLetters
     * Get letters configured to generate captcha
     *
     * @return string
     */
    protected function getLetters()
    {
        return $this->letters;
    }

    /**
     * getLength
     * Returns string length configured to generate captcha
     *
     * @return int
     */
    protected function getLength()
    {
        return $this->length;
    }

    /**
     * setLength
     * Set string length to generate captcha, and generate them if necessary
     *
     * @param  int $value
     * @return void
     */
    protected function setLength($value)
    {
        if (isset($this->length)) {
            if ($value != $this->length) {
                $this->length = $value;
                $this->text = $this->random();
            }
        } else {
            $this->length = $value;
            $this->text = $this->random();
        }
    }

    /**
     * getText
     * Returns text configured to show into image
     *
     * @return string
     */
    protected function getText()
    {
        return $this->text;
    }

    /**
     * setText
     * Set string text to generate image, it set length if necessary
     *
     * @param  mixed $value
     * @return void
     */
    protected function setText($value)
    {
        $this->text = $value;
        $this->length = strlen($value);
    }


    /**
     * random
     * Generates a random string. It uses
     * @uses TextImage::$length to generate text
     * @uses TextImage::$letters to get letters availables to generate text
     *
     * @return string
     */
    protected function random()
    {
        $str = '';
        for ($i = 0; $i < $this->length; $i++) {
            $str .= substr($this->letters, mt_rand(0, strlen($this->letters) - 1), 1);
        }
        return $str;
    }

    private function addNoise($img)
    {
        $textColor = $this->hexToRGB($this->textColor);

        $textColor = imagecolorallocate($img, $textColor['r'], $textColor['g'], $textColor['b']);

        $noiceColor = $this->hexToRGB($this->noiceColor);
        $noiceColor = imagecolorallocate($img, $noiceColor['r'], $noiceColor['g'], $noiceColor['b']);

        /* generating lines randomly in background of image */
        if ($this->noiceLines > 0) {
            for ($i = 0; $i < $this->noiceLines; $i++) {
                imageline(
                    $img,
                    mt_rand(0, $this->imgWidth),
                    mt_rand(0, $this->imgHeight),
                    mt_rand(0, $this->imgWidth),
                    mt_rand(0, $this->imgHeight),
                    $noiceColor
                );
            }
        }

        if ($this->noiceDots > 0) {/* generating the dots randomly in background */
            for ($i = 0; $i < $this->noiceDots; $i++) {
                imagefilledellipse(
                    $img,
                    mt_rand(0, $this->imgWidth),
                    mt_rand(0, $this->imgHeight),
                    mt_rand(2, 8),
                    mt_rand(2, 8),
                    $noiceColor
                );
            }
        }

        return $img;
    }

    /*function to convert hex value to rgb array*/
    protected function hexToRGB($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }

        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('r' => $r, 'g' => $g, 'b' => $b);
    }


    /*function to get center position on image*/
    protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8)
    {
        $xi = imagesx($image);
        $yi = imagesy($image);
        $box = imagettfbbox($size, $angle, $font, $text);
        $xr = abs(max($box[2], $box[4]));
        $yr = abs(max($box[5], $box[7]));
        $x = intval(($xi - $xr) / 2);
        $y = intval(($yi + $yr) / 2);
        return array($x, $y);
    }


    public function __get($property)
    {
        $method = "get" . ucfirst($property);
        if (method_exists(Text2Image::class, $method)) {
            return $this->$method();
        }
    }

    public function __set($property, $value)
    {
        $method = "set" . ucfirst($property);
        if (method_exists(Text2Image::class, $method)) {
            return $this->$method($value);
        }
    }
}
