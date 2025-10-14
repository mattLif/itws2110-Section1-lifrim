# itws2110-Section1-lifrim

Repo - https://github.com/mattLif/itws2110-Section1-lifrim

Sources:
- https://free-apis.github.io/
    - Used to find second API
- https://www.abstractapi.com/api/holidays-api
    - I used their holidays api
- https://www.here.com/
    - Used for documentation on geolocation api
- https://nominatim.org/
    - Used for documentation on nominatim's openstreetmap api
- ChatGPT
    - Used for understanding how api calls worked and for explaining errors to me that I did not understand

Hello!
For lab 3, I implemented API calls to OpenWeatherAPI and AbstractAPI's holiday API. Going into this I had very little experience using APIs, so I relied heavily on the API documentation found on the websites of the APIs I used. The HTML and CSS were simple to develop, but it was the JavaScript that gave me difficulty. I releid on the examples/code snippets from class and was able to fetch the data from the OpenWeatherAPI easily, but found difficulty when trying to implement the holiday API I wanted to use. At first, I tried using HolidayAPI, a free API I found online, but through extensive debugging and ChatGPT querying on why the data was not fetching, I learned the the free plan for that specific API restricted JavaScript from making calls to their API, so I switched to Abstract API's holiday API, which was much better in terms of documentation. It took me a while to figure out how to get and format today's date. After that, I decided to fetch the user's location through the geolocation api, so I used their website to study the documentation. This was cool, but I also wanted their town and state, not just their lat and lon, so I implemented nominatim's openstreetmap API to achieve this. Sometimes, Nominatim fails, and other times it doesn't, and I can't pinpoint why, so I implemented a fallback so my app at least always shows the weather of Troy NY, it just takes a while to load because the nominatim needs to timeout. I believe it has to do with too many API calls in short succession, so they temporarily block more calls, but I can't be sure. I also used their website for documentation. Overall, I became much more familiar with APIs and am satisfied with the Java Script behind my weather application.