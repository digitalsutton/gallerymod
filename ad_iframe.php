<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  
      <?php
      if (!empty($_GET['kw'])) {
        $kw = 'kw=' . str_replace(',', ';kw=', htmlspecialchars($_GET['kw'], ENT_QUOTES, 'UTF-8'));
      }
      
      if (!empty($_GET['tagpath'])) {
        $darttags = htmlspecialchars($_GET['tagpath'], ENT_QUOTES, 'UTF-8');
      }
    
      ?>
  
  <body style="border: none; height: auto; margin: 0; padding: 0; width: 250px;">
     <script src="http://ad.doubleclick.net/adj/<?php print $darttags; ?>kw=<?php print $kw ?>ord='+ord+'?'"></script>
  </body>
</html>
