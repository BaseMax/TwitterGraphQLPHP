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
- `deleteTweet(tweetId: ID!): Boolean`: Delete a

Copyright 2023, Max Base
