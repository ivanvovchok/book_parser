# Book parser
by Ivan Vovchok

## Installation

1. Clone the repository:
```bash
git clone git@github.com:ivanvovchok/book_parser.git
```
2. Go to the project directory:
```bash
cd book_parser
```
3. Install the requirements:
```bash
composer install
```
4. Create an `.env` file by copying the example:
```bash
cp .env.example .env
```
5. Generate the application key:
```bash
php artisan key:generate
```
6. Run the migrations:
```bash
php artisan migrate
```
7. Start the server:
```bash
php artisan serve
```

## Usage
Open your browser and go to `http://localhost:8000` to access the application.

### Books import
To import books, you can use the following command:
```bash
php artisan app:import-books
```

### Endpoints

- `GET /api/books` - Get books. Pass filters as query parameters:
  - `title` - Filter by book title.
  - `description` - Filter by book description.
  - `author_id` - Filter by author ID.

- `GET /api/authors` - Get authors. Pass filters as query parameters:
  - `name` - Filter by author name.
  
- `GET /api/authors/{id}/books` - Get books by author ID.
