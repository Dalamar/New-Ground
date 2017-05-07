## Laravel 5.4 based API consumer and on-the-fly custom data injector
Please run ```composer install``` after downloading the project.

### Configuration
All you need to do is to obtain [newsapi API key](https://newsapi.org/account) and [Skyscanner API key](http://portal.business.skyscanner.net/ru-ru/accounts/dashboard/?r=true) and provide them in `.env` file like so:
```
NEWSAPI_KEY=1e7496493bla-bla-bla
SKYSCANNER_KEY==2f7496493bla-bla-bla
```

### Performance optimization
I recommend to cache Laravel configuration and routes for better performance.
```shell
  php artisan config:cache && php artisan route:cache && php artisan optimize
  ```

### Response caching
Api controllers are caching processed result for 1 minute.

#### API features
This custom API mimics two main newsapi.org API resources:
- https://newsapi.org/v1/sources
- https://newsapi.org/v1/articles

And one of Skyscanner resource:
- http://partners.api.skyscanner.net/apiservices/browsequotes/v1.0

Assuming you will run this application using `php artisan serve`


#### Example for News API
- To get available sources use following URI: [http://127.0.0.1:8000/api/newsapi/sources](http://127.0.0.1:8000/api/newsapi/sources)
Sample output:
```json
{
	"status": "success",
	"message": [],
	"payload": {
		"status": "ok",
		"sources": [{
			"id": "abc-news-au",
			"name": "ABC News (AU)",
			"description": "Australia's most trusted source of local, national and world news. Comprehensive, independent, in-depth analysis, the latest business, sport, weather and more.",
			"url": "http:\/\/www.abc.net.au\/news",
			"category": "general",
			"language": "en",
			"country": "au",
			"urlsToLogos": {
				"small": "",
				"medium": "",
				"large": ""
			},
			"sortBysAvailable": ["top"]
		}, {
			"id": "usa-today",
			"name": "USA Today",
			"description": "Get the latest national, international, and political news at USATODAY.com.",
			"url": "http:\/\/www.usatoday.com\/news",
			"category": "general",
			"language": "en",
			"country": "us",
			"urlsToLogos": {
				"small": "",
				"medium": "",
				"large": ""
			},
			"sortBysAvailable": ["top", "latest"]
		}]
	},
	"time": "2017-05-02 19:04:28"
}
 ```
- To get customized articles for source `abc-news-au` use following URI: [http://127.0.0.1:8000/api/newsapi/articles/abc-news-au](http://127.0.0.1:8000/api/newsapi/articles/abc-news-au)
Sample output:

```json
{
	"status": "success",
	"message": [],
	"payload": {
		"status": "ok",
		"source": "abc-news-au",
		"sortBy": "top",
		"articles": [{
			"author": "http:\/\/www.abc.net.au\/news\/henry-belot\/7953986",
			"title": "PM announces 'Gonski 2.0' schools review, funding boost",
			"description": "The Federal Government says it will overhaul education funding in a bid to end the school funding wars, but Labor has condemned the plan as an act of political bastardry.",
			"url": "http:\/\/www.abc.net.au\/news\/2017-05-02\/malcolm-turnbull-announces-schools-funding-boost\/8489806",
			"urlToImage": "http:\/\/www.abc.net.au\/news\/image\/8490274-1x1-700x700.jpg",
			"publishedAt": "2017-05-02T08:08:15Z",
			"NG_Description": "Custom description",
			"NG_Review": "Custom review"
		}, {
			"author": "http:\/\/www.abc.net.au\/news\/sophie-mcneill\/4516794",
			"title": "'Day from hell': A doctor's account of the Khan Sheikhoun chemical attack",
			"description": "Dr Marmoun Morad was in Khan Sheikhoun when it was hit by a chemical attack. He told Lateline it was like seeing the end of the world.",
			"url": "http:\/\/www.abc.net.au\/news\/2017-05-02\/day-from-hell-khan-sheikhoun-chemical-attack\/8489214",
			"urlToImage": "http:\/\/www.abc.net.au\/news\/image\/8489466-1x1-700x700.jpg",
			"publishedAt": "2017-05-02T14:43:29Z",
			"NG_Description": "Custom description",
			"NG_Review": "Custom review"
		}]
	},
	"time": "2017-05-02 19:06:20"
}
```

#### Example for Skyscanner
- To get browse quotes use following URI: [http://127.0.0.1:8000/api/skyscanner/browsequotes/ES/eur/en-US/uk/us/2017-06-19/2017-06-20](http://127.0.0.1:8000/api/skyscanner/browsequotes/ES/eur/en-US/uk/us/2017-06-19/2017-06-20)
Sample output:

```json
    {
    	"status": "success",
    	"message": [],
    	"payload": {
    		"Quotes": [{
    			"QuoteId": 1,
    			"MinPrice": 413,
    			"Direct": false,
    			"OutboundLeg": {
    				"CarrierIds": [1929],
    				"OriginId": 65655,
    				"DestinationId": 68033,
    				"DepartureDate": "2017-06-19T00:00:00"
    			},
    			"InboundLeg": {
    				"CarrierIds": [1929],
    				"OriginId": 68033,
    				"DestinationId": 65655,
    				"DepartureDate": "2017-06-20T00:00:00"
    			},
    			"QuoteDateTime": "2017-05-07T02:58:00",
    			"NG_Description": "Custom description",
    			"NG_Review": "Custom review"
    		}, {
    			"QuoteId": 2,
    			"MinPrice": 2255,
    			"Direct": true,
    			"OutboundLeg": {
    				"CarrierIds": [857],
    				"OriginId": 65698,
    				"DestinationId": 68033,
    				"DepartureDate": "2017-06-19T00:00:00"
    			},
    			"InboundLeg": {
    				"CarrierIds": [857],
    				"OriginId": 68033,
    				"DestinationId": 65698,
    				"DepartureDate": "2017-06-20T00:00:00"
    			},
    			"QuoteDateTime": "2017-04-26T19:06:00",
    			"NG_Description": "Custom description",
    			"NG_Review": "Custom review"
    		}]
        },
        "time": "2017-05-07 20:48:43"
     }
```

#### Automation testing
Feel free to run feature tests to check is everything still works as expected:
  ```shell
  ./vendor/bin/phpunit
  ```