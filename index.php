<?php

    $set = false;
   if($set === false) {
    $cityData = file_get_contents('Nassarawa.json');
    $json = json_decode($cityData, true);
     

    $apiKey = "487bd1490c3597e54e7821c02bdc3e04";
    $cityId = '2335953';
    $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);
    $data = json_decode($response);
    $currentTime = time();

   } 
    


    if(isset($_POST['city'])) {
        $apiKey = "487bd1490c3597e54e7821c02bdc3e04";
        $cityId = $_POST['city'];
        $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($response);
        $currentTime = time();

        $set = true;

        if(isset($cityData[$_POST['city']])) {
           $cityname = $cityData[$_POST['city']];
           echo $cityname['name'];
       }

       foreach ($json as $city) {
        if ($city['id'] == $_POST['city']) {
            $cityname = $city['name'];
            break; 
        }
    }

    

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="weather-app">
        <div class="weather-container">
            <h1>Weather App</h1>
            <form id="weather-form" method="post">
                <label for="city">Select City:</label>
                <select name="city" id="city" class="select" required>

             <?php
                 foreach($json as $row) {
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                 }
             ?>
                </select>
                <button type="submit">Get Weather</button>
            </form>
            <?php
                if($set === false) {
            ?>
            <div class="weather-info">
                <h2>Weather in <span id="city-name"> Keffi </span></h2>
                <div class="weather-details">
                <div class="weather-forecast">
            <img src="https://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" />
                    <p>Temperature: Max<span id="temperature"><?php echo $data->main->temp_max; ?>°C</span>  Min <span id=""><?php echo $data->main->temp_min; ?>°C</span> </p>
                    <p>Wind: <span id="conditions"><?php echo $data->wind->speed; ?> km/h</span></p>
                    <p>Humidity: <span id="humidity"><?php echo $data->main->humidity; ?>%</span></p>
                </div>
            </div>
        </div>
        <?php } else if($set === true) {?>
            <div class="weather-info">
              
                <h2>Weather in <span id="city-name"> <?=$cityname?> </span></h2>
                <div class="weather-details">
                <div class="weather-forecast">
            <img src="https://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" />
                    <p>Temperature: Max <span id="temperature"><?php echo $data->main->temp_max; ?>°C</span>  Min <span id=""><?php echo $data->main->temp_min; ?>°C</span> </p>
                    <p>Wind: <span id="conditions"><?php echo $data->wind->speed; ?> km/h</span></p>
                    <p>Humidity: <span id="humidity"><?php echo $data->main->humidity; ?>%</span></p>
                </div>
            </div>
        </div>
        <?php }?>


        <br/>
        <center> Simple Weather APP USING API - Shuraih99 </center>
    </div>
</body>
</html>
