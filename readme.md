# chmod

![php 8.2](https://img.shields.io/badge/php-8.2-brightgreen?style=flat)

![Banner](./banner.svg)

`chmod.php` will reset folder's permissions to 755 and 644 for files, this for the folder where the script is stored and any subfolders.

## Use it

Just copy the chmod.php script in a folder of your site where you wish reset any permissions. Use your FTP client to do this.

1.  Get a raw version of the script : click on the raw button or go to this URL : [https://github.com/cavo789/chmod/blob/master/chmod.php](https://github.com/cavo789/chmod/blob/master/chmod.php)
2.  On your computer, start a text editor like Notepad or Notepad++ and copy/paste there the code,
3.  If needed, change here permissions depending on your host (755 for instance for the most hosting companies, 705 for OVH, ...),
4.  Save the file (if you're using Notepad++, check in the Encoding menu that you've selected UTF8 NoBom as encoding)
5.  Put the saved file in a folder of your server

## Run it

Start a browser and run the file i.e go to f.i. [http://site/chmod.php](http://site/chmod.php).

The script will start immediatly and reset folder's permissions to, by default, 755 and 644 for files. This recursively.

## Remark

Don't forget to remove the script once you've finished with it.

## Credits

Christophe Avonture | [https://www.avonture.be](https://www.avonture.be)
