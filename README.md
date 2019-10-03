### API для загрузки данных о матчах

#### Загрузка одной игры

> POST http://localhost:9090/game

##### Параметры

|Name|Required|Format|Description|
|----|--------|------|-----------|
|sport|true|string|Вид спорта|
|team1|true|string|Название команды 1|
|team2|true|string|Название команды 2|
|date|true|string (Y-m-d H:i:s)|Дата начала матча|
|source|true|string|Источник|
|lang|true|string|Язык|

Можно отправить как 

form data

    date=2019-01-02%2010:00:00&
    team1=Реал&
    team2=Барселона&
    league=Лига%20чемпионов%20УЕФА&
    sport=footbal&
    lang=ru&
    source=sportdata4.com

json

    {
      "team1": "Реал",
      "team2": "Барселона",
      "league": "Лига чемпионов УЕФА",
      "date": "2019-01-02 10:00:00",
      "source": "sportdata4.com",
      "sport": "footbal",
      "lang": "ru"
    }

    
#### Пакетная загрузка

> POST http://localhost:9090/game_package

##### Параметры

|Name|Required|Format|Description|
|----|--------|------|-----------|
|sport[]|true|string|Вид спорта|
|team1[]|true|string|Название команды 1|
|team2[]|true|string|Название команды 2|
|date[]|true|string (Y-m-d H:i:s)|Дата начала матча|
|source[]|true|string|Источник|
|lang[]|true|string|Язык|

Примеры

form data

    date[]=2019-01-02%2010:00:00&
    team1[]=Реал&
    team2[]=Барселона&
    league[]=Лига%20чемпионов%20УЕФА&
    sport[]=footbal&
    source[]=sportdata4.com&
    lang[]=ru&
    date[]=2019-01-22%2010:00:00&
    team1[]=Атлетико&
    team2[]=Осасуна&
    league[]=Лига%20чемпионов%20УЕФА&
    sport[]=footbal&
    source[]=sportdata4.com&
    lang[]=ru
    
json

    [
        {
          "team1": "Реал",
          "team2": "Барселона",
          "league": "Лига чемпионов УЕФА",
          "date": "2019-01-02 10:00:00",
          "source": "sportdata4.com",
          "sport": "footbal",
          "lang": "ru"
        },
         //...
    ]

#### Получить информацию о случайной игре 

> GET http://localhost:9090/random_match

|Name|Required|Format|Description|
|----|--------|------|-----------|
|date1|false|string (Y-m-d H:i:s)|Фильтр по дате начала игры|
|date2|false|string (Y-m-d H:i:s)|Фильтр по дате начала игры|
|source|false|string|Фильтр по источнику|

Пример ответа

    { 
       "sport":"футбол",
       "league":"Лига чемпионов УЕФА",
       "team1":"Атлетико Мадрид",
       "team2":"Осасуна",
       "date":"2019-01-01 13:00:00",
       "bufferCount":2
    }
