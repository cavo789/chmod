<?php

/*
 * Author : AVONTURE Christophe - https://www.avonture.be.
 *
 * Reset folder's permissions to 755 and 644 for files, this for
 * the folder where the script is stored and any subfolders
 */

define('REPO', 'https://github.com/cavo789/chmod');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('html_errors', '1');
ini_set('docref_root', 'http://www.php.net/');
ini_set('error_prepend_string', "<div style='color:red; font-family:verdana; border:1px solid red; padding:5px;'>");
ini_set('error_append_string', '</div>');
error_reporting(E_ALL);

// Get the GitHub corner
$github = '';
if (is_file($cat = __DIR__ . DIRECTORY_SEPARATOR . 'octocat.tmpl')) {
    $github = str_replace('%REPO%', REPO, file_get_contents($cat));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

    <?php echo $github; ?>
   <div class="container">
      <div class="jumbotron">
         <div class="container"><h1>Recursive chmod</h1></div>
      </div>

<?php

ini_set('max_execution_time', '0');
ini_set('set_time_limit', '0');

function rChmod($dir = './')
{
    $sReturn='';

    $d=new RecursiveDirectoryIterator($dir);

    // By default the chmod for a file should be 644 but, on some hoster, it should be 640.
    // To determine this, just get the chmod of this file, this script and use it as default
    $chmodFile=substr(sprintf('%o', fileperms(__FILE__)), -4);

    foreach (new RecursiveIteratorIterator($d, 1) as $path) {
        // Don't process folders starting with a dot
        if ('.' == substr(basename($path), 0, 1)) {
            continue;
        }

        // Get the current chmod
        $current=substr(sprintf('%o', fileperms($path)), -4);

        // Determine the good permission, the one the folder/file should have
        $attr=($path->isDir() ? '0755' : $chmodFile);

        if ($path->isDir()) {
            // No need to make something if the current chmod is 755 or 750
            $continue=!in_array($current, ['0755', '0750']);

            // On a Windows OS, don't bother for chmod 777
            if ($continue && (('WIN' === strtoupper(substr(PHP_OS, 0, 3))) && ('0777' == $current))) {
                $continue=false;
            }
        } else {
            // it's a file
            $continue=!in_array($current, ['0666', '0644', '0640']);
        }

        if (true === $continue) {
            // The permission of the folder/file isn't correct

            chmod($path, octdec($attr));
            $newchmod=substr(sprintf('%o', fileperms($path)), -4);

            if ($attr != octdec($newchmod)) {
                $sReturn .= '<li class="text-danger" style="font-size:2em;">ERROR - The current chmod for ' . $path . ' is ' . octdec($newchmod) . ' and should be ' . octdec($attr) . ' - EXITING</li>';

                break;
            } else {
                $sReturn .= '<li class="text-success">' . $path . ' is now ' . octdec($newchmod) . '</li>';
            }
        }
    }

    if ('' != $sReturn) {
        $sReturn='<ul>' . $sReturn . '</ul>';
    } else {
        $sReturn='<p class="text-success">Nothing to change, chmods already correct</p>';
    }

    return $sReturn;
}

// Start immediately
echo rChmod('.');

?>
   </div>
</body>
</html>
