## Laravel 5.4 based newsapi.org API consumer
Please run ```composer install``` after downloading the project.

### Configuration
All you need to do is to [obtain newsapi API key](https://newsapi.org/account) and provide it in `.env` file like so:
`NEWSAPI_KEY=1e7496493bla-bla-bla`

#### API features
This custom API mimics two main newsapi.org API resources:
- https://newsapi.org/v1/sources
- https://newsapi.org/v1/articles

Assuming you will run this application using `php artisan serve`

- To get available sources use following URI: [http://127.0.0.1:8000/api/sources](http://127.0.0.1:8000/api/sources)
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
- To get customized articles for source `abc-news-au` use following URI: [http://127.0.0.1:8000/api/articles/abc-news-au](http://127.0.0.1:8000/api/articles/abc-news-au)
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

#### Automation testing
Feel free to run feature tests to check is everything still works as expected:
  ```shell
  ./vendor/bin/phpunit
  ```