<?php
if (!function_exists('admin_asset')) {
    function admin_asset($asset)
    {
        return url('packages/module/admin/assets/' . $asset);
    }
}

if (!function_exists('module_asset')) {
    function module_asset($module, $asset)
    {
        return url('packages/module/' . $module . '/assets/' . $asset);
    }
}

if (!function_exists('front_asset')) {
    function front_asset($asset)
    {
        return url(Config::get('front::base_asset_url') . $asset);
    }
}

if (!function_exists('urlencode2')) {
    function urlencode2($str)
    {
        return urlencode(urlencode($str));
    }
}

if (!function_exists('urldecode2')) {
    function urldecode2($str)
    {
        return urldecode(urldecode($str));
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}

if (!function_exists('number_list')) {
    function number_list($start, $end, $leading_zeros = null, $step = 1)
    {
        $out = array();
        $range = range($start, $end, $step);
        if (is_numeric($leading_zeros)) {
            foreach ($range as $num) {
                $tmp = sprintf("%0{$leading_zeros}d", $num);
                $out[$tmp] = $tmp;
            }
        } else {
            foreach ($range as $num) {
                $out[$num] = $num;
            }
        }
        return $out;
    }
}

if (!function_exists('dir_list')) {
    function dir_list($dir)
    {
        $out = array();
        $files = File::files($dir);

        if ($files) {
            foreach ($files as $file) {
                $pathParts = pathinfo($file);
                $out[$pathParts['basename']] = $pathParts['basename'];
            }
        }

        return $out;
    }
}

if (!function_exists('image_text_wrap')) {
    function image_text_wrap($fontSize, $fontFace, $string, $width)
    {
        $ret = "";
        $arr = explode(' ', $string);

        foreach ($arr as $word) {
            $testString = $ret . ' ' . $word;
            $testBox = imagettfbbox($fontSize, 0, $fontFace, $testString);
            if ($testBox[2] > ($width + $width * 0.1)) {
                $ret .= ($ret == "" ? "" : "\n") . $word;
            } else {
                $ret .= ($ret == "" ? "" : ' ') . $word;
            }
        }

        return $ret;
    }
}

// Delete files older than date in secounds
if (!function_exists('clean_dir')) {
    function clean_dir($dir, $date = null)
    {
        if (is_null($date)) {
            File::cleanDirectory($dir);
        } else {
            $files = File::files($dir);
            if ($files) {
                foreach ($files as $file) {
                    if (filemtime($file) < (time() - $date)) {
                        unlink($file);
                    }
                }
            }
        }
    }
}

if (!function_exists('text_block')) {
    function text_block($text, $fontfile, $fontsize, $width)
    {
        $words = explode(' ', $text);
        $lines = array($words[0]);
        $currentLine = 0;
        for ($i = 1; $i < count($words); $i++) {
            $lineSize = imagettfbbox($fontsize, 0, $fontfile, $lines[$currentLine] . ' ' . $words[$i]);
            if ($lineSize[2] - $lineSize[0] < $width) {
                $lines[$currentLine] .= ' ' . $words[$i];
            } else {
                $currentLine++;
                $lines[$currentLine] = $words[$i];
            }
        }

        return implode("\n", $lines);
    }
}

if (!function_exists('process_closure')) {
    function process_closure($closure)
    {
        $out = $closure;
        return $out;
    }
}

if (!function_exists('active_url')) {
    function active_url($url, $contains = false)
    {
        $out = false;
        if ($contains) {
            if (strpos(Request::url(), $url) !== false) $out = 'class="active"';
        } else {
            if (Request::url() == $url) $out = 'class="active"';
        }
        return $out;
    }
}

if (!function_exists('filter_opacity')) {
    function filter_opacity(&$img, $opacity) //params: image resource id, opacity in percentage (eg. 80)
    {
        if (!isset($opacity)) {
            return false;
        }
        $opacity /= 100;

        //get image width and height
        $w = imagesx($img);
        $h = imagesy($img);

        //turn alpha blending off
        imagealphablending($img, false);

        //find the most opaque pixel in the image (the one with the smallest alpha value)
        $minalpha = 127;
        for ($x = 0; $x < $w; $x++)
            for ($y = 0; $y < $h; $y++) {
                $alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
                if ($alpha < $minalpha) {
                    $minalpha = $alpha;
                }
            }

        //loop through image pixels and modify alpha for each
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                //get current alpha value (represents the TANSPARENCY!)
                $colorxy = imagecolorat($img, $x, $y);
                $alpha = ($colorxy >> 24) & 0xFF;
                //calculate new alpha
                if ($minalpha !== 127) {
                    $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
                } else {
                    $alpha += 127 * $opacity;
                }
                //get the color index with new alpha
                $alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
                //set pixel with the new color + opacity
                if (!imagesetpixel($img, $x, $y, $alphacolorxy)) {
                    return false;
                }
            }
        }
        return true;
    }
}


if (!function_exists('parsePageSignedRequest')) {
    function parsePageSignedRequest()
    {
        if (isset($_REQUEST['signed_request'])) {
            $encoded_sig = null;
            $payload = null;
            list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
            $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
            $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
            return $data;
        }
        return false;
    }
}

if (!function_exists('dj')) {
    function dj()
    {
        $out = array();
        $numargs = func_num_args();
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            $out[] = $arg_list[$i];
        }
        echo json_encode($out);
    }
}

