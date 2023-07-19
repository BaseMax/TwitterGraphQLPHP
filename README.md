# Twitter Clone API - GraphQL-Based in PHP8

This project aims to create a Twitter clone API using GraphQL in PHP8. The API will provide all the necessary queries and mutations to replicate essential features of Twitter. It enables users to perform actions such as creating tweets, following other users, liking tweets, retweeting, and more.

## Prerequisites

-Before running the Twitter Clone API, ensure you have the following installed:

- PHP 8 or higher
- Composer (Dependency Manager for PHP)
- MySQL or any compatible database server
- Redis (for caching)

## Installation

Clone the repository:

```bash
git clone https://github.com/your-username/twitter-clone-api.git
cd twitter-clone-api
```

Install dependencies:

```bash
composer install
```

Configure the environment:

Copy the `.env.example` file to `.env` and set the required environment variables such as database credentials and Redis configuration.

Set up the database:

Run database migrations to set up the required tables:

```bash
php artisan migrate
```

Start the development server:

```bash
php -S localhost:8000 -t public
```

## GraphQL Schema

The Twitter Clone API provides the following queries and mutations:

### Queries

- `user(username: String!): User: Get a user's profile information by their username.
- `tweet(id: ID!): Tweet: Get a specific tweet by its ID.
- `timeline(userId: ID!): [Tweet!]!: Get the user's timeline (tweets from the users they follow).

### Mutations

- `createUser(input: CreateUserInput!): User`: Create a new user account.
- `createTweet(input: CreateTweetInput!): Tweet`: Create a new tweet.
- `followUser(userId: ID!): User`: Follow another user.
- `unfollowUser(userId: ID!): User`: Unfollow a previously followed user.
- `likeTweet(tweetId: ID!): Tweet`: Like a tweet.
- `unlikeTweet(tweetId: ID!): Tweet`: Remove a like from a previously liked tweet.
- `retweet(tweetId: ID!): Tweet`: Retweet a tweet.
- `deleteTweet(tweetId: ID!): Boolean`: Delete a tweet.

## Authentication

To perform certain mutations, such as creating tweets, following users, liking tweets, or retweeting, you need to authenticate your requests. Please include an authentication token in the request headers using the following format:

```makefile
Authorization: Bearer YOUR_AUTH_TOKEN
```

The API uses JWT (JSON Web Tokens) for authentication. To obtain an authentication token, you can use the login mutation, passing your username and password as input, and it will return a token that you can use for subsequent requests.

## Error Handling

The API handles errors using GraphQL's built-in error handling mechanisms. If an error occurs, the API will provide meaningful error messages with relevant details.

## Caching

To improve performance, the API utilizes Redis caching for certain queries and data. Cached data will be served when available, reducing the load on the database.

## Testing

The API comes with a suite of unit tests and integration tests. To run the tests, execute the following command:

```bash
phpunit
```

## Documentation

For more information on the API's schema, queries, and mutations, you can access the GraphQL documentation tool at http://localhost:8000/graphql-playground after starting the development server.

## Contribution

Contributions to the Twitter Clone API project are welcome.

Copyright 2023, Max Base
