# IMDB Movie Searcher

A lightweight PHP + vanilla JS web app that lets users search for movies and view detailed information via the [OMDb API](https://www.omdbapi.com/). No framework, no build step — just a single PHP file acting as both the API proxy and the front-end.

## Tech Stack

- **PHP 7+** — back-end / API proxy
- **Vanilla JS** — front-end (no frameworks)
- **OMDb API** — movie data source
- Any PHP-capable web host

## Setup

1. Clone the repo:
   ```bash
   git clone https://github.com/risha-b427/imdb-movie-searcher
   ```
2. Upload `api.php` to your web server root (rename to `index.php` if preferred).
3. Get a free API key at [omdbapi.com/apikey.aspx](https://www.omdbapi.com/apikey.aspx).
4. Open `api.php` and replace the value of `$apiKey` with your key:
   ```php
   $apiKey = "your_api_key_here";
   ```

No dependencies or composer packages required.

---

## API Endpoints

Both endpoints are on the same file (`api.php`). Pass `type` as a query parameter to select the operation.

---

### Search movies

```
GET api.php?type=search&movie={title}
```

Search for movies by title. Returns up to 10 results from OMDb.

| Parameter | Type   | Required | Description                        |
|-----------|--------|----------|------------------------------------|
| `type`    | string | required | Must be `search`                   |
| `movie`   | string | required | Movie title to search for          |

**Example request:**
```
GET api.php?type=search&movie=Inception
```

**Example response:**
```json
{
  "Search": [
    {
      "Title": "Inception",
      "Year": "2010",
      "imdbID": "tt1375666",
      "Type": "movie",
      "Poster": "https://..."
    }
  ],
  "totalResults": "1",
  "Response": "True"
}
```

---

### Get movie details

```
GET api.php?type=details&id={imdbID}
```

Fetch full metadata for a single title by its IMDb ID.

| Parameter | Type   | Required | Description                        |
|-----------|--------|----------|------------------------------------|
| `type`    | string | required | Must be `details`                  |
| `id`      | string | required | IMDb ID, e.g. `tt1375666`          |

**Example request:**
```
GET api.php?type=details&id=tt1375666
```

**Example response:**
```json
{
  "Title": "Inception",
  "Year": "2010",
  "Director": "Christopher Nolan",
  "Actors": "Leonardo DiCaprio, ...",
  "Genre": "Action, Adventure, Sci-Fi",
  "Language": "English, Japanese, French",
  "Country": "United States, United Kingdom",
  "Plot": "A thief who steals corporate secrets...",
  "Response": "True"
}
```

---

## Error Responses

All errors return `Response: "False"` with an `Error` field.

| Condition                     | Error message              |
|-------------------------------|----------------------------|
| No movie title given          | `No movie title entered`   |
| No IMDb ID given              | `No IMDb ID provided`      |
| Missing or unknown `type`     | `Invalid request`          |
| No results from OMDb          | e.g. `Movie not found!`    |

**Example:**
```json
{ "Response": "False", "Error": "No movie title entered" }
```

---

## Front-End Behaviour

The bundled UI (rendered when visiting the page in a browser) exposes two JS functions:

| Function                  | Triggered by        | Action                                              |
|---------------------------|---------------------|-----------------------------------------------------|
| `searchMovies()`          | Search button click | Calls `type=search`, renders a clickable results list |
| `getMovieDetails(imdbID)` | Click on a result   | Calls `type=details`, renders the detail view       |

Clicking a result replaces the list with the detail view. A "Back to results" button re-invokes `searchMovies()` with the last query.

---

## Security Notes

The API key is stored as a plain string inside the PHP file. For production use, consider moving it to an environment variable:

```php
// Recommended: load from environment
$apiKey = getenv("OMDB_API_KEY");
```

The current implementation passes user input through `urlencode()` before appending to the OMDb URL, which prevents URL injection. However, there is no server-side rate limiting or input length validation.

---

