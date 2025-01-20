## Blog-Api

This is a simple Blog API built using Laravel for an interview task. The API provides functionalities to manage blog posts with implemented features such as API routes, resources, policies, and activity logging using Spatie.

## Features
- API Routes: Defined routes for handling blog-related operations.
- Resources: Transforming API responses with Laravel resources.
- Policies: Access control for blog-related actions.
- Spatie Activity Log: Tracks and logs changes made to the blog system.
- API Documentation: Postman documentation is available.

## Installation
1. Clone the repository: 

    ```
    git clone git@github.com:eldeeno/blog-api.git
    cd blog-api
    ```
2. Install dependencies:

   ``composer install``
3. Copy the .env file and configure database settings:

    ``cp .env.example .env``
4. Generate the application key:

    ``php artisan key:generate``
4. Run the migration and seed the database:

    ``php artisan migrate --seed``
5. Start the development server:

    ``php artisan serve``
6. Access the API using Postman or any other API client.

## API Documentation

Refer to the Postman documentation for available endpoints and usage details:
[Postman API Documentation](Blog-Apis.postman_collection.json)

## Usage

Use any API testing tool (such as Postman) to interact with the API.

Ensure to include the required authentication tokens where necessary.

## Technologies Used

- [Laravel](www.laravel.com)
- MySQL
- [Spatie Activity Log Package](https://spatie.be/docs/laravel-activitylog/v4/introduction)
- Postman (for API documentation)
- 
## License
This project is for interview purposes only.

For any inquiries, feel free to reach out! [_eldeeno](https://twitter.com/_eldeeno)

