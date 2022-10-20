<html>
 <head>
  <title>reserve</title>
 </head>
 <body>
 <?php 
    echo '<p>Your data is:</p>'; 
    if($_GET['set'] == "1")
    {
        echo '<p>Layered Arch</p>';
    }
    elseif($_GET['set'] == "2")
    {
        echo "<p>Modern Round</p>";
    }
    elseif($_GET['set'] == "3")
    {
        echo "<p>Vintage Mirrors</p>";
    }
    elseif($_GET['set'] == "4")
    {
        echo "<p>Dark Walnut</p>";
    }
    else
    {
        echo '<p>Rustic Wood</p>';
    }
    
    echo $_GET[date];
    echo $_GET[subpackage];
    echo $_GET[delivery];
 </body>
</html>