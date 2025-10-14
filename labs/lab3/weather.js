// My API keys
const weatherApiKey = '4bb9ed31d2c2545dcc76ccb949d0ec42';
const holidaysApiKey = '9e5d662882704dffbfff2181ba9878eb';

// Fallback coordinates (Troy, NY)
const fallbackLat = 42.7284;
const fallbackLon = -73.6918;

// Function to fetch weather given latitude and longitude
function fetchWeather(lat, lon) {
    // Fetch weather for provided location
    const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=imperial&appid=${weatherApiKey}`;
    fetch(weatherUrl)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            // Get specific data for weather and append to respective HTML element
            const temp = data.main.temp.toFixed(1);
            const humidity = data.main.humidity;
            const wind = data.wind.speed;
            const description = data.weather[0].description;
            const iconCode = data.weather[0].icon;

            document.getElementById('condition').textContent = description
                .split(' ')
                .map(w => w[0].toUpperCase() + w.slice(1))
                .join(' ');

            document.getElementById('temperature').textContent = `Temperature: ${temp} °F`;
            document.getElementById('humidity').textContent = `Humidity: ${humidity}%`;
            document.getElementById('wind').textContent = `Wind: ${wind} mph`;
            document.getElementById('icon').src = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
            document.getElementById('icon').alt = description;
        })
        .catch(err => {
            console.error('Failed to fetch weather:', err);
            document.getElementById('condition').textContent = 'Error loading weather data.';
        });
}

// Get user's geolocation
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // Use Nominatim to get state and town
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
            .then(res => res.json())
            .then(data => {
                const city = data.address.city || data.address.town || data.address.village || '';
                const state = data.address.state || '';
                document.getElementById('location').textContent = `${city}, ${state}`;

                // Fetch weather for user's location
                fetchWeather(lat, lon);
            })
            .catch(err => {
                // Fallback to Troy, NY if Nominatim fails
                console.error('Reverse geocoding failed:', err);
                document.getElementById('location').textContent = 'Troy, NY';
                fetchWeather(fallbackLat, fallbackLon);
            });

    }, error => {
        // Fallback if geolocation fails
        console.error('Geolocation error:', error);
        document.getElementById('location').textContent = 'Troy, NY';
        document.getElementById('condition').textContent = 'Weather unavailable';
        fetchWeather(fallbackLat, fallbackLon);
    });
} else {
    document.getElementById('location').textContent = 'Geolocation not supported';
    document.getElementById('condition').textContent = 'Weather unavailable';
    fetchWeather(fallbackLat, fallbackLon);
}

// Get today's date and format for API call
const today = new Date();
const year = today.getFullYear();
const month = String(today.getMonth() + 1).padStart(2, '0');
const day = String(today.getDate()).padStart(2, '0');
const holidaysUrl = `https://holidays.abstractapi.com/v1/?api_key=${holidaysApiKey}&country=US&year=${year}&month=${month}&day=${day}&region=NY`;

// Fetch Today's holidays and append to HTML
fetch(holidaysUrl)
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('holidays');
        container.innerHTML = '';
        if (data.length === 0) {
            container.textContent = 'No holiday today.';
        } else {
            // Display holidays and exclude repeats
            const seen = new Set();
            data.forEach(holiday => {
                if (!seen.has(holiday.name)) {
                    seen.add(holiday.name);
                    const div = document.createElement('div');
                    div.className = 'holiday';
                    div.textContent = `${holiday.date}: ${holiday.name}`;
                    container.appendChild(div);
                }
            });
        }
    })
    .catch(err => {
        console.error('Failed to fetch holiday:', err);
        document.getElementById('holidays').textContent = 'Error loading holiday.';
    });

