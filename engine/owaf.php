<?php
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}
function get_web_page($url)
{
    $user_agent = 'Mozilla/4.0 (compatible;)';

    $options = array(

        CURLOPT_CUSTOMREQUEST => "GET", //set request type post or get
        CURLOPT_POST => false, //set to GET
        CURLOPT_USERAGENT => $user_agent, //set user agent
        CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        CURLOPT_FOLLOWLOCATION => true, // follow redirects
        CURLOPT_ENCODING => "", // handle all encodings
        CURLOPT_AUTOREFERER => true, // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 2, // timeout on connect
        CURLOPT_TIMEOUT => 30, // timeout on response
        CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER  => 0, //ignore ssl
		CURLOPT_SSL_VERIFYHOST  => 0, //ignore ssl
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['errno'] = $err;
    $header['errmsg'] = $errmsg;
    $header['content'] = $content;
    return $header;
}

function get_ver($page)
{

    if (str_contains($page, '<td class="lgnBL">') !== false || str_contains($page, 'Copyright (c) 2006 Microsoft Corporation') !== false || str_contains($page, '<td class="lgnBM">') !== false || str_contains($page, 'background-color:#0072C6') !== false)
    {
        return 'old exchange';
    }
    elseif (str_contains($page, '<div class="sidebar">') !== false || str_contains($page, 'Copyright (c) 2011 Microsoft Corporation') !== false || str_contains($page, 'Default to mouse class') !== false || str_contains($page, '@font-face') !== false) 
    {
        return 'new exchange';
    }
    elseif (preg_grep('/^Copyright \(c\) ([0-9]{4}) Microsoft Corporation/', array(
        $page
    )))
    {
        return 'other exchange';
    }
    else
    {
        return 'not exchange';
    }

}

function getmxser($domain)
{
    $hosts = array();
    getmxrr($domain, $hosts);
    return $hosts[0];
}

function check_owa($url)
{

    $result = get_web_page("https://mail.$url/owa");

    if (get_ver($result['content']) == 'not exchange')
    {
        $result = get_web_page("https://autodiscover.$url/owa");
        if (get_ver($result['content']) == 'not exchange')
        {
            $result = get_web_page("https://webmail.$url/owa");
            if (get_ver($result['content']) == 'not exchange')
            {
                $result = get_web_page("https://owa.$url/owa");
                if (get_ver($result['content']) == 'not exchange')
                {
                    $result = get_web_page("https://qmail7.$url/owa");
                    if (get_ver($result['content']) == 'not exchange')
                    {
                        $result = get_web_page("https://" . getmxser($url));
                        return get_ver($result['content']);
                    }
                    else
                    {
                        return get_ver($result['content']);
                    }

                }
                else
                {
                    return get_ver($result['content']);
                }

            }
            else
            {
                return get_ver($result['content']);
            }

        }
        else
        {
            return get_ver($result['content']);
        }

    }
    else
    {
        return get_ver($result['content']);
    }
}

//echo check_owa("du.ae");
