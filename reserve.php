<html>
 <head>
  <title>reserve</title>
 </head>
 <body>
 <?php 
    echo '<p>Your data is:</p>'; 
    if($_GET['option'] == "1")
    {
        echo '<p>Layered Arch</p>';
    }
    elseif($_GET['option'] == "2")
    {
        echo "<p>Modern Round</p>";
    }
    elseif($_GET['option'] == "3")
    {
        echo "<p>Vintage Mirrors</p>";
    }
    elseif($_GET['option'] == "4")
    {
        echo "<p>Dark Walnut</p>";
    }
    else
    {
        echo '<p>Rustic Wood</p>';
    }
    
    echo $_GET[date]
    echo [date];
    echo $_GET[subpackage];
    echo [subpackage];
    echo $_GET[delivery];
    echo [delivery];
 </body>
</html>