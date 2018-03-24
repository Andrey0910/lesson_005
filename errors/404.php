404 not found
<br>
<?php
if (file_exists("../debug")):
?>
Error: <br><pre>
    <?php
echo 'line'.$e->getLine()."<br>";
echo 'File'.$e->getLine()."<br>";
echo $e->getMessage()."<br>";
echo $e->getTraceAsString()."<br>";
endif;
//echo "Не определеная ошибка.";
