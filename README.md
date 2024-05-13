# Books API

## About

This project provides a RESTful API for managing books in a library.

## Installation

1. Clone the repository:

   `git clone <repository-url>`

2. Navigate to the project directory:

   `cd <project-directory>`

3. Install PHP dependencies:

   `composer install`

4. Start the Docker containers:

   `./vendor/bin/sail up -d`

## Usage

1. Run database migrations to ensure database schema is up-to-date:

   `./vendor/bin/sail artisan migrate`

2. Generate a personal access client for Passport:

   `./vendor/bin/sail artisan passport:client --personal`

3. Create a new user (replace `{name}`, `{email}`, and `{password}`):

   `./vendor/bin/sail artisan user:create {name} {email} {password}`

4. Create a token for a user (replace `{user_id}` with the actual user ID):

   `./vendor/bin/sail artisan token:create {user_id}`

## Endpoints

### Books

- GET `/api/books`: Retrieve a list of all books.
- POST `/api/books`: Create a new book.
- GET `/api/books/{id}`: Retrieve details of a specific book.
- PATCH `/api/books/{id}`: Update details of a specific book.
- DELETE `/api/books/{id}`: Delete a specific book.

## Contributing

Contributions are welcome! Please feel free to submit issues or pull requests.

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
