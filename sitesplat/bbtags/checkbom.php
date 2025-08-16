<?php
/**
 * @author  Atanas Vasilev
 * @link    http://pastebin.com/dHbqjUNy
 * @see     http://www.dotvoid.com/2010/04/detecting-utf-bom-byte-order-mark/
 * @version 1.1
 */


// SETTINGS
////////////////////////////////////////////////////////////////////////////////
$check_extensions = array('php');


// MAIN
////////////////////////////////////////////////////////////////////////////////
define('STR_BOM', "\xEF\xBB\xBF");
$file = null;
$directory = getcwd();

$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::CHILD_FIRST);
echo '<h1>BOM Check</h1>';
try
{
  foreach ($rit as $file)
  {
    if ($file->isFile())
    {
      $path_parts = pathinfo($file->getRealPath());

      if (isset($path_parts['extension']) && in_array($path_parts['extension'],$check_extensions))
      {
        $object = new SplFileObject($file->getRealPath());

        if (false !== strpos($object->getCurrentLine(), STR_BOM))
        {
          echo $file->getRealPath().'<br />';
        } else
		{
			 echo $file->getRealPath().' no bom <br />';
		}
      }
    }
  }

}
catch (Exception $e)
{
  die ('Exception caught: '. $e->getMessage());
}

?>
