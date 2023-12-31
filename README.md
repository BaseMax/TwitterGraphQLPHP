# Twitter Clone API - GraphQL-Based in PHP8

This project aims to create a Twitter clone API using GraphQL in PHP8. The API will provide all the necessary queries and mutations to replicate essential features of Twitter. It enables users to perform actions such as creating tweets, following other users, liking tweets, retweeting, and more.

## Prerequisites

-Before running the Twitter Clone API, ensure you have the following installed:

- PHP 8 or higher
- Composer (Dependency Manager for PHP)
- MySQL or any compatible database server

## Installation

Clone the repository:

```bash
git clone https://github.com/BaseMax/TwitterGraphQLPHP.git
cd TwitterGraphQLPHP
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
php migrate.php
```

Start the development server:

```bash
php -S localhost:8000 public/index.php
```

## GraphQL Schema

The Twitter Clone API provides the following queries and mutations:

### Queries

- `user(username: String!): User`: Get a user's profile information by their username.
- `tweet(id: ID!): Tweet`: Get a specific tweet by its ID.
- `timeline(userId: ID!): [Tweet!]!`: Get the user's timeline (tweets from the users they follow).

### Mutations

- `createUser(input: CreateUserInput!): User`: Create a new user account.
- `createTweet(input: CreateTweetInput!): Tweet`: Create a new tweet.
- `followUser(userId: ID!): User`: Follow another user.
- `unfollowUser(userId: ID!): User`: Unfollow a previously followed user.
- `likeTweet(tweetId: ID!, userId: ID!): Tweet`: Like a tweet.
- `unlikeTweet(tweetId: ID!, userId: ID!): Tweet`: Remove a like from a previously liked tweet.
- `retweet(tweetId: ID!, userId: ID!): Tweet`: Retweet a tweet.
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

## GraphQL Models

```graphql
type User {
  id: ID!
  username: String!
  name: String!
}

type Tweet {
  id: ID!
  text: String!
  author: User!
}

input CreateUserInput {
  username: String!
  password: String!
  name: String!
}

input CreateTweetInput {
  text: String!
}

type Query {
  user(username: String!): User
  tweet(id: ID!): Tweet
  timeline(userId: ID!): [Tweet!]!
}

type Mutation {
  createUser(input: CreateUserInput!): User
  createTweet(input: CreateTweetInput!): Tweet
  followUser(userId: ID!): User
  unfollowUser(userId: ID!): User
  likeTweet(tweetId: ID!): Tweet
  unlikeTweet(tweetId: ID!): Tweet
  retweet(tweetId: ID!): Tweet
  deleteTweet(tweetId: ID!): Boolean
}
```

## cURL Testing

### Query: user(username: String!): User

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"{ user(username: \"example_user\") { id username name } }"}' YOUR_API_URL
```

### Query: tweet(id: ID!): Tweet

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"{ tweet(id: \"example_tweet_id\") { id text author { id username } } }"}' YOUR_API_URL
```

### Query: timeline(userId: ID!): [Tweet!]!

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"{ timeline(userId: \"example_user_id\") { id text author { id username } } }"}' YOUR_API_URL
```

### Mutation: createUser(input: CreateUserInput!): User

```bash
curl -X POST -H "Content-Type: application/json" -d '{"query":"mutation { createUser(input: { username: \"new_user\", password: \"password123\", name: \"New User\" }) { id username name } }"}' YOUR_API_URL
```

### Mutation: createTweet(input: CreateTweetInput!): Tweet

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { createTweet(input: { text: \"This is a new tweet!\" }) { id text author { id username } } }"}' YOUR_API_URL
```

### Mutation: followUser(userId: ID!): User

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { followUser(userId: \"user_to_follow_id\") { id username } }"}' YOUR_API_URL
```

### Mutation: unfollowUser(userId: ID!): User

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { unfollowUser(userId: \"user_to_unfollow_id\") { id username } }"}' YOUR_API_URL
```

### Mutation: likeTweet(tweetId: ID!): Tweet

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { likeTweet(tweetId: \"tweet_to_like_id\") { id text author { id username } } }"}' YOUR_API_URL
```

### Mutation: unlikeTweet(tweetId: ID!): Tweet

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { unlikeTweet(tweetId: \"tweet_to_unlike_id\") { id text author { id username } } }"}' YOUR_API_URL
```

### Mutation: retweet(tweetId: ID!): Tweet
```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { retweet(tweetId: \"tweet_to_retweet_id\") { id text author { id username } } }"}' YOUR_API_URL
```

### Mutation: deleteTweet(tweetId: ID!): Boolean

```bash
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer YOUR_AUTH_TOKEN" -d '{"query":"mutation { deleteTweet(tweetId: \"tweet_to_delete_id\") }"}' YOUR_API_URL
```

## Graphical Examples:

![Screenshot from 2023-07-22 15-27-32](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/0a9f40b0-f95a-4a82-a1dd-909350ad7ed1)
![Screenshot from 2023-07-22 17-26-50](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/c2fabb93-cc84-4033-ab67-7b6b2cad7446)
![Screenshot from 2023-07-22 17-36-35](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/dfe41c95-18ad-4e45-bf3b-f7545b410ac1)
![Screenshot from 2023-07-22 17-42-20](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/baba1e98-cca5-400b-bd4d-38660dac224e)
![Screenshot from 2023-07-22 18-10-35](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/f4976723-f52e-47bb-9188-4d35df053a41)
![Screenshot from 2023-07-22 18-19-03](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/fcb89741-ce48-4c83-a56e-88a77e936a5c)
![Screenshot from 2023-07-22 18-32-00](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/255fc790-80ea-4f11-92d9-587650307e39)
![Screenshot from 2023-07-22 18-39-54](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/52561a3a-e010-4bbd-ad06-ce74717371be)
![Screenshot from 2023-07-22 19-00-37](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/e6af708b-a933-496f-afd6-a2c9152690aa)
![Screenshot from 2023-07-22 22-00-09](https://github.com/BaseMax/TwitterGraphQLPHP/assets/107758775/104ba151-ea86-4e9d-a007-864e3269f54c)

Make sure to replace YOUR_API_URL with the actual URL of your GraphQL API endpoint and YOUR_AUTH_TOKEN with a valid authentication token obtained from the login mutation, if required.

## Documentation

For more information on the API's schema, queries, and mutations, you can access the GraphQL documentation tool at `http://localhost:8000/graphql-playground` after starting the development server.

## Contribution

Contributions to the Twitter Clone API project are welcome.

**Authors:**

- Ali Ahmadi
- Max Base

Copyright 2023, Max Base
