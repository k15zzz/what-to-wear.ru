var weather = DataFromDB();
var date = new Date();
var minutes = date.getMinutes();
var hour = date.getHours();
var day = date.getDay();
var dayWeek;
var weatherCondition;
var weatherImage;
var things = GetThings(weather.temperature);

switch (day)
{
    case 0: dayWeek="Sunday"; break;
    case 1: dayWeek="Monday"; break;
    case 2: dayWeek="Tuesday"; break;
    case 3: dayWeek="Wednesday"; break;
    case 4: dayWeek="Thursday"; break;
    case 5: dayWeek="Friday"; break;
    case 6: dayWeek="Saturday"; break;
}

switch (weather.weatherCondition)
{
    case "clear": weatherCondition ="ясно"; weatherImage="clear"; break;
    case "partly-cloudy": weatherCondition ="малооблачно"; weatherImage="cloudy"; break;
    case "cloudy": weatherCondition ="облачно с прояснениями"; weatherImage="cloudy";  break;
    case "overcast": weatherCondition ="пасмурно"; weatherImage="overcast";  break;
    case "drizzle": weatherCondition ="морось"; weatherImage="rain"; break;
    case "light-rain": weatherCondition ="небольшой дождь"; weatherImage="rain";  break;
    case "rain": weatherCondition ="дождь"; weatherImage="raining";  break;
    case "moderate-rain": weatherCondition ="умеренно сильный дождь"; weatherImage="raining";  break;
    case "heavy-rain": weatherCondition ="сильный дождь"; weatherImage="raining";  break;
    case "continuous-heavy-rain": weatherCondition ="длительный сильный дождь"; weatherImage="raining";  break;
    case "showers": weatherCondition ="ливень"; weatherImage="raining";  break;
    case "wet-snow": weatherCondition ="дождь со снегом"; weatherImage="snowy"; break;
    case "light-snow": weatherCondition ="небольшой снег"; weatherImage="snowy"; break;
    case "snow": weatherCondition ="снег"; weatherImage="snowy"; break;
    case "snow-showers": weatherCondition ="снегопад"; weatherImage="snowy"; break;
    case "hail": weatherCondition ="град"; weatherImage="storm";  break;
    case "thunderstorm": weatherCondition ="гроза"; weatherImage="storm";  break;
    case "thunderstorm-with-rain": weatherCondition ="дождь с грозой"; weatherImage="storm";  break;
    case "thunderstorm-with-hail": weatherCondition ="гроза с градом"; weatherImage="storm";  break;
}

if (minutes<10){
    minutes = "0"+minutes;
}

if (hour<10){
    hour = "0"+hour;
}

$(window).load(function() {
    $('.preloader').fadeOut().end().delay(400).fadeOut('slow');

    $('.time').html(hour + ":" + minutes );

    $('.dayWeek').html(dayWeek);

    $('.temperature').html(weather.temperature + "°C");
    $('.temperatureFeelsLike').html("Ощущается " + weather.temperatureFeelsLike  + "°C");
    $('.weatherCondition').html("В Тюмени " + weatherCondition);
    $('.windSpeed').html("Скорость ветра " + weather.windSpee + " м/с");
    $('.airHumidity').html("Влажность воздуха " + weather.airHumidity + "%");
    $('.probabilityPrecipitation').html("Вероятность осадков "+weather.probabilityPrecipitation+ "%");

    $('.weather').replaceWith('<img src="image/'+weatherImage+'.png" alt="Погода" class="weather">');

    $('.things').replaceWith('<img src="image/things/'+things+'.png" alt="Погода" class="things">');

    if (hour >= 7 && hour < 12) {
        $(".container").css({
            'background':'linear-gradient(-45deg, #fdda7e, #fdeabb, #c25c2f, #e89a67)',
            'background-size':'400% 400%',
            'animation':'gradient 15s ease infinite'
        });
    } else if (hour >= 12 && hour < 19) {
        $(".container").css({
            'background':'linear-gradient(-45deg, #1b3d2f, #50713a, #f3e4ae, #02c3b5)',
            'background-size':'400% 400%',
            'animation':'gradient 15s ease infinite'
        });
    } else if (hour >= 19 && hour < 24) {
        $(".container").css({
            'background':'linear-gradient(-45deg, #1e123a, #a73252, #e8b58e, #fae7d9)',
            'background-size':'400% 400%',
            'animation':'gradient 15s ease infinite'
        });
    } else if (hour >= 0 && hour < 7) {
        $(".container").css({
            'background':'linear-gradient(-45deg, #070708, #111f28, #484e52, #aeb8c4)',
            'background-size':'400% 400%',
            'animation':'gradient 15s ease infinite'
        });
    };
});

function DataFromDB () {
    var weather;
    $.ajax({
        type: "GET",
        url: '../server/json.php',
        async: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function (db) {
            weather = db;
        }
    });
    return weather;
};

function GetThings(temperature){
    if (temperature>20){
        return "t-shirt2";
    }
    else if (temperature<=20&&temperature>15){
        return "t-shirt";
    }
    else if (temperature<=14 && temperature>10){
        return "t-shirt-and-bomber2";
    }
    else if (temperature<=10&&temperature>5){
        return "t-shirt-and-bomber";
    }
    else if (temperature<=5&&temperature>0){
        return "hold";
    }
    else if (temperature<=0&&temperature>-5){
        return "hold";
    }
    else if (temperature<=-5&&temperature>-10){
        return "hold";
    }
    else if (temperature<=10&&temperature>-20){
        return "hold";
    }
    else if (temperature<=-20&&temperature>-50){
        return "hold";
    }
    else {
        return "costume";
    }
}