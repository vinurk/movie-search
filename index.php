<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./main.css">
    <title>movie</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Teko:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div id="home_cover">
        <div class="vignette-overlay"></div>
        <div class="gradient-overlay"></div>

        <div id="head_container">
            <div id="home_head" class="unselectable-text">
                NOTFLIX
            </div>
            <div id="profile_det_sec">
                <div id="profile_inline_container">
                    <div id="profile_pic_bg" class="common-element-shadow">
                        <div id="profile_pic_img"></div>
                    </div>
                </div>
                <div id="inline_dropdown_container">
                    <div id="profile_drop_down"></div>
                </div>
            </div>`
        </div>

        <div id="sub-home-section">
            <div class="wrapper">
                <div class="searchBar">
                    <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search" value="" />
                    <button id="searchQuerySubmit"  name="searchQuerySubmit" onclick="url='http://localhost/movie_search/search.php?q='+document.getElementById('searchQueryInput').value;window.location.href=url">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="#666666"
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="web_nav-links">
                <a class="nav-link" href="http://localhost/movie_search/">Home</a>
                <a class="nav-link" href="">Top Rated</a>
                <!-- <a class="nav-link" href="">Add Movie</a> -->
            </div>
        </div>
    </div>

    <div id="main_content_container">
        <div id="recommendation_subsection" class="genre_sub_section">
            <div class="sub_heading" id="recommend_heading">
                Recommendations
            </div>
            <div class="cards_container">
                <?php
        
        // Database credentials
                    $hostname = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "movie_db";

                    try {
                        // Create a PDO connection
                        $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        // Set the PDO error mode to exception

                        
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    
                ?>
                <?php
                     $query = "SELECT * FROM movie_details LIMIT 10 ";
                     $stmt = $conn->query($query);
                     $movies_det = $stmt->fetchAll(PDO::FETCH_ASSOC);

                     if (!empty($movies_det)) {
                         // Loop through the data and do something with it
                         foreach ($movies_det as $movie) {
                             echo "<div class='movie_card card_dimension' id=movie_" .$movie['id']. ">
                                 <a href='./about.php?id=".$movie['id']."'>
                                     <img src='https://image.tmdb.org/t/p/original/".$movie['poster_path']. "' alt='' class='card_dimension'>
                                 </a>
                                 </div>";
                         }
                     } else {
                         echo "No movie found";
                     }
                ?>
               
            </div>
            <div class="subsection_more_section">
                <button class="button-24" role="button">Show More</button>
            </div>
        </div>
        

    </div>
    <br><br><br><br><br><br><br><br>



</body>

</html>