<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricul Farm</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/weather.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        body {
            background-image: url('images/wbackgrnd.jpg');
            background-size: cover;
        }
    </style>
</head>

<body>

    <!-- search box & search button -->
    <form id="search">
        <input type="search" placeholder="Enter City Name" id="search-input" required autocomplete="off">
        <br>
        <button id="search-button">Search</button>
    </form><br>
    <!-- card for details -->
    <main id="app-container">
        <!-- location -->
        <div id="location">
            <p>City</p>
        </div>
        <!-- temperature -->
        <div id="temp">
            <img id="temp-icon" src="images/sun.png" alt="sun icon">
            <p><span id="m">Min:</span id="m"><span id="temp-value">Temp&nbsp;</span><span id="temp-unit">&#176C</span> &emsp;
                <span id="m">Max:</span id="m"><span id="temp-value2">Temp&nbsp;</span><span id="temp-unit2">&#176C</span>
            </p>
        </div>
        <!-- climate -->
        <div id="climate">
            <p>Current Climate</p>
        </div>
    </main>

    <!-- js: open weather API key[openweathermap.org, current weather data(feach current location weather & search city weather)] -->
    <script>
        // declare variables to access html id's
        let loc = document.getElementById("location");
        let tempicon = document.getElementById("temp-icon");
        let tempvalue = document.getElementById("temp-value");
        let tempvalue2 = document.getElementById("temp-value2");
        let climate = document.getElementById("climate");
        let iconfile;
        const searchInput = document.getElementById("search-input");
        const searchbutton = document.getElementById("search-button");

        // search city weather
            // stop browser refresh on clicking search button
            searchbutton.addEventListener('click', (e) => {
                e.preventDefault();
                getWeather(searchInput.value); // take search city from user
                searchInput.value = '';
            });

            // 
            const getWeather = async (city) => {
                try {
                    //api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}
                    const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=d565d2187d680a87980a6f837dfffa5a `, {
                        mode: 'cors'
                    });
                    // fetch data is in json format, so then convert json file in text
                    const weatherData = await response.json(); 

                    // display on console
                    console.log(weatherData);
                    // convert in text
                    const {
                        name
                    } = weatherData;
                    const {
                        feels_like
                    } = weatherData.main;
                    const {
                        id,
                        main
                    } = weatherData.weather[0];

                    // set city, temp & climate
                    loc.textContent = name;
                    climate.textContent = main;
                    tempvalue.textContent = Math.round(feels_like - 273);
                    tempvalue2.textContent = Math.round(feels_like - 269);

                    // weather conditions = auto main generate(climate) with given icons
                    if (id < 300 && id > 200) {
                        tempicon.src = "images/thunderstorm.png"
                    } else if (id < 400 && id > 300) {
                        tempicon.src = "images/clear-sky.png"
                    } else if (id < 600 && id > 500) {
                        tempicon.src = "images/rain-day.png"
                    } else if (id < 700 && id > 600) {
                        tempicon.src = "images/snow.png"
                    } else if (id < 800 && id > 700) {
                        tempicon.src = "images/clouds.png"
                    } else if (id == 800) {
                        tempicon.src = "images/clouds and sun.png"
                    }
                } catch (error) {
                    alert('City not found'); //for wrong/blank input(city)
                }
            };



        // feach current location weather

            // allow current location & take longitude + latitude of user 
            window.addEventListener("load", () => {
                let lon;
                let lat;
                // user allow location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        lon = position.coords.longitude; // longitude of user
                        lat = position.coords.latitude; // latitude of user
                        //const proxy = "https://cors-anywhere.herokuapp.com/"; // cors-server(cros anywhere)

                        //fetch data from api key:geographic coordinates with api key 
                        //api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={API key}
                        const api = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=d565d2187d680a87980a6f837dfffa5a `
                        // fetch data from api & return data is in json format, so then convert json file in text
                        fetch(api).then((response) => {
                                return response.json(); //return data is in json format
                            })
                            .then(data => {
                                const {
                                    name
                                } = data;
                                const {
                                    feels_like
                                } = data.main;
                                const {
                                    id,
                                    main
                                } = data.weather[0];
                                // set city, temp & climate
                                loc.textContent = name;
                                climate.textContent = main;
                                tempvalue.textContent = Math.round(feels_like - 273); // Kelvin to Celsius by -273
                                tempvalue2.textContent = Math.round(feels_like - 269);
                                
                                // display on console
                                console.log(data);

                                // weather conditions = auto main generate(climate) with given icons
                                if (id < 300 && id > 200) {
                                    tempicon.src = "images/thunderstorm.png"
                                } else if (id < 400 && id > 300) {
                                    tempicon.src = "images/clear-sky.png"
                                } else if (id < 600 && id > 500) {
                                    tempicon.src = "images/rain-day.png"
                                } else if (id < 700 && id > 600) {
                                    tempicon.src = "images/snow.png"
                                } else if (id < 800 && id > 700) {
                                    tempicon.src = "images/clouds.png"
                                } else if (id == 800) {
                                    tempicon.src = "images/clouds and sun.png"
                                }
                            })
                    })
                }
            })
    </script>

</body>
</html>