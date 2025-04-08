const apiKey = '0107d97cdf38e0e5554f0216b9e67166'; // Thay API Key ở đây
const city = 'Da Nang'; // Thay thành phố tùy ý
async function fetchWeather() {
    try {
        const response = await fetch(
            `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=vi&appid=${apiKey}`
        );

        const data = await response.json();
        const weatherIcon = document.querySelector('.weather-icon');
        const weatherInfo = document.querySelector('.weather-info');
        const dateInfo = document.querySelector('.date-info');

        if (data.cod === 200) {
            const temp = Math.round(data.main.temp);
            const description = data.weather[0].description;

            // Cập nhật icon và thông tin thời tiết
            weatherIcon.textContent = getWeatherIcon(data.weather[0].main);
            weatherInfo.textContent = `${temp}°C - ${description}`;

            // Lấy ngày tháng hiện tại
            const today = new Date();
            const day = today.getDate();
            const month = today.getMonth() + 1; // Tháng bắt đầu từ 0 nên +1
            const year = today.getFullYear();

            dateInfo.textContent = ` Hôm nay: ${day}/${month}/${year}`;
        } else {
            weatherInfo.textContent = 'Không lấy được dữ liệu!';
            dateInfo.textContent = 'Lỗi dữ liệu!';
        }
    } catch (error) {
        console.error('Lỗi lấy dữ liệu thời tiết:', error);
        weatherInfo.textContent = 'Lỗi kết nối!';
        dateInfo.textContent = 'Lỗi kết nối!';
    }
}

// Hàm đổi icon dựa theo trạng thái thời tiết
function getWeatherIcon(weatherMain) {
    const icons = {
        Clear: '☀️',
        Clouds: '☁️',
        Rain: '🌧️',
        Drizzle: '🌦️',
        Thunderstorm: '⛈️',
        Snow: '❄️',
        Mist: '🌫️',

    };
    return icons[weatherMain] || '🌍';
}

fetchWeather();