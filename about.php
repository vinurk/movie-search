<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>movie</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Teko:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lisu+Bosa:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oleo+Script:wght@400;700&family=Signika+Negative:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./about_page.css">
</head>

<body>

    
    <?php
        
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "movie_db";

        if (isset($_GET['id'])) {
            $receivedId = $_GET['id'];
        }

        try {
            // Create a PDO connection
            $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            $query = "SELECT title,backdrop_path,overview,release_date,runtime,popularity,tagline FROM movie_details WHERE id=".$receivedId;
            $stmt = $conn->query($query);
            $movies_query_response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $old_data= $movies_query_response;

            

            // Set the PDO error mode to exception

            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        function display_data($movie_data,$col_name){
            if (!empty($movie_data)) {
                // Check if $col_name exists in the array
                if (isset($movie_data[0][$col_name])) {
                    // Loop through the data and do something with it
                    foreach ($movie_data as $row) {
                        return $row[$col_name];
                    }
                } 
                else{
                    echo"Greatest movie of all time.";
                }
            } else {
                echo "No movie found";
            }
        }

        if (!empty($movies_query_response)) {
            // Loop through the data and do something with it
            foreach ($movies_query_response as $row) {
                $backdrop_path = $row['backdrop_path'];

                echo "<div id='movie-banner-details' style='background-image: url(https://image.tmdb.org/t/p/original".$backdrop_path.");'>";
            }
        } else {
            echo "No movie found";
        }
    ?>


        <div class="gradient-overlay" id="gradient-left"></div>
        <div class="gradient-overlay" id="gradient-bottom"></div>

        <div class="vignette-overlay"></div>
        <div id="banner-container">
            <div id="web-title">
                <div id="web-title-text" class="unselectable-text">
                    <a href="http://localhost/movie_search/" style="text-decoration: none;">NOTFLIX</a>
                    
                </div>
            </div>
            <div id="movie-title">
                <div id="movie-title-text">
                    <?php
                        echo display_data($movies_query_response,'title');
                    ?>
                </div>
            </div>
            <div id="movie-desc">
                <p id="movie-desc-text">
                    <?php
                        echo display_data($movies_query_response,'overview');
                    ?>
                </p>
            </div>

            <div id="movie-rating-dur-year">
                <div id="movie-rating-dur-year-text" class="movie-end-details">
                    TMDb: 
                    <?php
                        echo round(display_data($movies_query_response,'popularity')/10,1);

                    ?> 
                    &emsp;&emsp; 
                    <?php
                        $time_in_min = display_data($movies_query_response,'runtime');
                        $hours = floor($time_in_min / 60);
                        $minutes = $time_in_min % 60;

                        // Format the result
                        $time_formatted = $hours . " hr " . $minutes . " min";

                        // Output the result
                        echo $time_formatted;

                    ?> 
                    &emsp;&emsp; 
                    <?php
                        $release_date = display_data($movies_query_response,'release_date');
                        $year = date('Y', strtotime($release_date));

                        // Output the year
                        echo $year;

                    ?> 

                </div>
            </div>

            <div id="movie-genre">
                <div id="movie-genre-text" class="movie-end-details">
                    <?php
                        $query = "SELECT genre FROM movie_genre,genres where movie_id=".$receivedId." and genre_id=id;";
                        $stmt = $conn->query($query);
                        $movies_query_response = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $genres = array();

                        foreach ($movies_query_response as $row) {
                            $genres[] = $row['genre'];
                        }

                        // Implode the genre names with the separator "·" and print the result
                        $genre_string = implode(' · ', $genres);
                        echo $genre_string;
                    ?>
                </div>
            </div>

            <div id="movie-watch">
                <div id="watch-button-container">
                    <?php
                        $query = "SELECT trailer_key FROM movie_db.videos WHERE movie_id=".$receivedId;
                        $stmt = $conn->query($query);
                        $video_link="";
                        $movies_query_response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($movies_query_response)) {
                            // Check if $col_name exists in the array
                             
                            if (isset($movies_query_response[0]["trailer_key"])) {
                                foreach ($movies_query_response as $row) {
                                    $video_link =  $row["trailer_key"];
                                    
                                }
                               
                            } 
                        }
                        
                        echo "<button class='button-24' role='button' onclick=\"window.open('https://youtube.com/watch?v=".$video_link."', '_blank');\">Watch Now</button>"
                    ?>
                </div>
            </div>
        </div>
        <div id="movie-tagline-container">
            <div id="movie-tagline-text">
                <?php
                    echo "“".display_data($old_data,'tagline')."”";
                ?>
            </div>
        </div>
        <div id="cast-sec">
            <div id="cast-heading-text">
                CAST
            </div>
            <div id="cast_catalogue">
            <?php
                

                $connection = mysqli_connect($hostname, $username, $password, $database);
                if (!$connection) {
                    die("Database connection failed: " . mysqli_connect_error());
                }

                // Step 2: Fetch data from the database
                $query = "SELECT DISTINCT c.name, c.profile_path
                            FROM cast c
                            JOIN movie_cast mc ON c.id = mc.cast_id
                            WHERE mc.movie_id =".$receivedId." LIMIT 10;";

                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                }

                // Step 3: Populate the HTML with cast names and images
                while ($row = mysqli_fetch_assoc($result)) {
                    $castName = $row['name'];
                    $imagePath = $row['profile_path'];

                    echo '<div class="cast-profile">';
                    echo '  <div class="cast-img" style="background-image: url(https://image.tmdb.org/t/p/original/' . $imagePath.');"></div>';
                    echo '  <div class="cast-name">' . $castName . '</div>';
                    echo '</div>';
                }

                // Step 4: Close the database connection
                mysqli_close($connection);
                ?>
            </div>
        </div>
    </div>
    
</body>

</html>
