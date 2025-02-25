let weather = {
  // API key for fetching weather data from OpenWeatherMap
  "apikey": "2ad3cb0770ad425ccbaf4189344ed8a2",

  // Function to fetch weather data for a given city
  fetchWeather: function (city) {
      // Making a fetch request to OpenWeatherMap API
      fetch(
          "https://api.openweathermap.org/data/2.5/weather?q=" 
          + city 
          + "&units=metric&appid=" 
          + this.apikey
      )
      // Handling the response as JSON
      .then((response) => response.json())
      // Passing the data to displayWeather method
      .then((data) => this.displayWeather(data));
  },

  // Function to display the fetched weather data on the webpage
  displayWeather: function(data) {
      // Destructuring the data to extract needed values
      const { name } = data; // City name
      const { icon, description } = data.weather[0]; // Weather icon and description
      const { temp, humidity } = data.main; // Temperature and humidity
      const { speed } = data.wind; // Wind speed

      // Log the weather data to the console for debugging
      console.log(name, icon, description, temp, humidity, speed);

      // Update the DOM elements with the weather data
      document.querySelector(".city").innerText = "Weather in " + name; // City name
      document.querySelector(".icon").src = "https://openweathermap.org/img/wn/" + icon + ".png"; // Weather icon
      document.querySelector(".description").innerText = description; // Weather description
      document.querySelector(".temp").innerText = temp + "°C"; // Temperature
      document.querySelector(".humidity").innerText = "Humidity " + humidity + "%"; // Humidity
      document.querySelector(".wind").innerText = "Wind Speed " + speed + "Km/h"; // Wind speed
      
      // Remove the loading class once weather data is displayed
      document.querySelector(".weather").classList.remove("loading");
  },

  // Function to initiate the weather fetch based on the user's search input
  search: function() {
      // Get the value from the search bar and fetch the weather for that city
      this.fetchWeather(document.querySelector(".search-bar").value);
  }
};

// Add an event listener to the search button to trigger the search when clicked
document.querySelector(".search button").addEventListener("click", function() {
  weather.search();
});

// Add an event listener to the search bar to trigger the search when the Enter key is pressed
document.querySelector(".search-bar").addEventListener("keyup", function(event) {
  // Check if the Enter key (key code 13) was pressed
  if (event.key == "Enter") {
      weather.search();
  }
});

// Fetch weather for Toronto by default when the page loads
weather.fetchWeather("Toronto");
