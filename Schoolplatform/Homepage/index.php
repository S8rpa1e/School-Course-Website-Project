<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        .Navigation .SearchBar { display: flex; align-items: center; }
        .Navigation .SearchBar input { border-radius: 8px 0 0 8px; border: 2px solid #ddd; border-right: none; padding: 8px 12px; outline: none; }
        .search-btn { padding: 8px 18px; background-color: #093981; color: #fff; border: none; border-radius: 0 8px 8px 0; cursor: pointer; font-weight: 600; font-size: 13px; transition: background .2s; }
        .search-btn:hover { background-color: #07296a; }
    </style>
</head>
<body>

<div class="Navigation">
    <ul>

        <li><a href="courses.php">Explore</a></li>

        <li>
            <form class="SearchBar" action="courses.php" method="GET">
                <input type="text" name="search" placeholder="Search courses...">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </li>

        <li id="AboutLink"><a href="#">About</a></li>
         
        <li id="LoginButton">
            <button >Login</button>
        </li>
    </ul>
</div>


    <div id="colors">
        <div id="color1"></div>
        <div id="Color2"></div>
        <div id="color3"></div>

        <div>
            <img src="kid.png" alt="">
        </div>
    </div>

    <div class="Left-Text">
        <div id="left-Test">
            <h1 id="LeftTextHead">Learn essential career and life skills</h1>
        </div>
        
        <div id="left-small-text">
            <p id="P1">Build in-demand skills fast and advance your career in a changing job market</p>
        </div>
    </div>

    <div class="Textboxes">
        <div id= TextBox1 >
            <div id="Text1.1">
                <H1>Certified Teachers</H1>
            </div>
            
            <div id="Text1.2">
                <p></p>
            </div>
        </div>

        <div id="TextBox2">
            <div id="Text2.1">
                <h1></h1>
            </div>

            <div id="Text2.2">
                <p>  </p>
            </div>
        </div>

        <div id="TextBox3">
            <div id="Text3.1">
                <h1></h1>
            </div>

            <div id="Text3.2">
                <p></p>
            </div>
        </div>
    </div>
    
</body>
</html>