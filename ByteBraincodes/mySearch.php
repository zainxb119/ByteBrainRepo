<?php 
if(isset($_REQUEST['S']))
{
    
    $expr = '/^[\w\d]{0,6}$/i';

    if (preg_match($expr, $_REQUEST['S'])) 
    {
        $S = $_REQUEST['S'];
    $hint = "";
    try 
    {
        require('connection.php');
     
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE title LIKE :title");
        $stmt->bindValue(":title", "%{$S}%");
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        foreach ($results as $result) 
        {
            //echo "<a href='myQuizview1.php?qid={$result["QZID"]}'>{$result["title"]}</a><br>";
            echo "<a href='myQuizview1.php?qid={$result["QZID"]}'><button type='button' class='list-group-item list-group-item-action dropdown-item'>{$result["title"]}</button></a>";
        }
        
        if($S !== "") 
        {
            $S = strtolower($S); //to ensure that the comparison is case-insensitive
            $len = strlen($S); 
            foreach($results as $r) 
            {
                if($S == strtolower(substr($r[3], 0, $len))) //substring of the title in database, where it starts at the first letter till the length of the entered value
                {
                    if($hint === "") {
                        $hint = $r[3];
                    } else {
                        $hint .= ",{$r[3]}";
                    }
                }
            }
        }
        
        if($hint === "") 
        {
            echo "<button type='button' class='list-group-item list-group-item-action dropdown-item'>No more suggestions found</button>";
        } 
        else 
        {
            echo $hint;
        }
    } 
    catch(PDOException $e) {
        die($e->getMessage());
    }
}
    
    else{
        echo"No data found";
    }
}
?>
