<?php

use App\DB;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;


$createUserInputType = new InputObjectType([
    "name" => "CreateUserInput",
    "fields" => [
        "username" => [
            "type" => Type::nonNull(Type::string())
        ],
        "password" => [
            "type" => Type::nonNull(Type::string())
        ],
        "name" => [
            "type" => Type::nonNull(Type::string())
        ]
    ]
]);

$createTweetInputType = new InputObjectType([
    "name" => "CreateTweetInput",
    "fields" => [
        "text" => [
            "type" => Type::nonNull(Type::string())
        ],
        "userId" => [
            "type" => Type::nonNull(Type::id())
        ]
    ]
]);

$userType = new ObjectType([
    "name" => "User",
    "fields" => [
        "id" => [
            "type" => Type::id()
        ],
        "username" => [
            "type" => Type::string()
        ],
        "name" => [
            "type" => Type::string()
        ]
    ]
]);

$tweetType = new ObjectType([
    "name" => "Tweet",
    "fields" => [
        "id" => [
            "type" => Type::id()
        ],
        "text" => [
            "type" => Type::string()
        ],
        "author" => [
            "type" => $userType,
            "resolve" => function ($tweet, $args, $context) {
                $user = DB::getUserById($tweet["author"], $context["db"]);
                return [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "username" => $user["username"]
                ];
            }
        ]
    ]
]);

$queryType = new ObjectType([
    "name" => "Query",
    "fields" => [
        "user" => [
            "type" => $userType,
            "args" => [
                "username" => [
                    "type" => Type::nonNull(Type::string())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $user = DB::getUserByUsername($args["username"], $context["db"]);
                return [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "username" => $user["username"]
                ];
            }
        ],
        "tweet" => [
            "type" => $tweetType,
            "args" => [
                "id" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $tweet = DB::getTweetById($args["id"], $context["db"]);
                return [
                    "id" => $tweet["id"],
                    "text" => $tweet["text"],
                    "author" => $tweet["author"]
                ];
            }
        ],
        "timeline" => [
            "type" => Type::nonNull(Type::listOf($tweetType)),
            "args" => [
                "userId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $tweets = DB::getTimeLine($args["userId"], $context["db"]);
                return $tweets;
            }
        ]
    ]
]);



$mutationType = new ObjectType([
    "name" => "Mutation",
    "fields" => [
        "createUser" => [
            "type" => $userType,
            "args" => [
                "input" => [
                    "type" => Type::nonNull($createUserInputType)
                ],
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $input = $args["input"];
                $user = DB::createUser($input, $context["db"]);

                return [
                    "id" => $user->getId(),
                    "name" => $user->getName(),
                    "username" => $user->getUsername()
                ];
            }
        ],
        "createTweet" => [
            "type" => $tweetType,
            "args" => [
                "input" => [
                    "type" => Type::nonNull($createTweetInputType)
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $input = $args["input"];
                $tweet = DB::createTweet($input, $context["db"]);
                return [
                    "id" => $tweet->getId(),
                    "text" => $tweet->getText(),
                    "author" => $tweet->getAuthor()->getId()
                ];
            }
        ],
        "followUser" => [
            "type" => $userType,
            "args" => [
                "userId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $user = DB::getUserById($args["userId"], $context["db"]);
                return [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "username" => $user["username"]
                ];
            }
        ],
        "unfollowUser" => [
            "type" => $userType,
            "args" => [
                "userId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $user = DB::getUserById($args["userId"], $context["db"]);
                return [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "username" => $user["username"]
                ];
            }
        ],
        "likeTweet" => [
            "type" => $tweetType,
            "args" => [
                "tweetId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $tweet = DB::getTweetById($args["tweetId"], $context["db"]);
                return [
                    "id" => $tweet["id"],
                    "text" => $tweet["text"],
                    "author" => $tweet["author"]
                ];
            }
        ],
        "unlikeTweet" => [
            "type" => $tweetType,
            "args" => [
                "tweetId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $tweet = DB::getTweetById($args["tweetId"], $context["db"]);
                return [
                    "id" => $tweet["id"],
                    "text" => $tweet["text"],
                    "author" => $tweet["author"]
                ];
            }
        ],
        "retweet" => [
            "type" => $tweetType,
            "args" => [
                "tweetId" => [
                    "type" => Type::nonNull(TYpe::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                $tweet = DB::getTweetById($args["tweetId"], $context["db"]);
                $newTweet = DB::createTweet([
                    "text" => $tweet["text"],
                    "userId" => $args["userId"]
                ], $context["db"]);

                return [
                    "id" => $newTweet->getId(),
                    "text" => $newTweet->getText(),
                    "author" => $newTweet->getAuthor()->getId()
                ];
            }
        ],
        "deleteTweet" => [
            "type" => Type::boolean(),
            "args" => [
                "tweetId" => [
                    "type" => Type::nonNull(Type::id())
                ]
            ],
            "resolve" => function ($rootValue, $args, $context) {
                DB::deleteTweet($args["tweetId"], $context["db"]);
                return true;
            }
        ]
    ]
]);


return [
    "query" => $queryType,
    "mutation" => $mutationType
];
