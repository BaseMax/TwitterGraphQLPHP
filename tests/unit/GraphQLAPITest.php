<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class GraphQLAPITest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client([
            "base_uri" => "http://localhost:8000/"
        ]);
    }

    public function testUserQuery()
    {
        $response = $this->client->post("", [
            "json" => [
                "query" => '{ user(username: "ahmadi") { id username name } }'
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey("data", $data);
        $this->assertArrayHasKey("user", $data["data"]);
    }

    public function testTweetQuery()
    {
        $response = $this->client->post("", [
            "json" => [
                "query" => "query {tweet (id: \"64bbde82c1223\") {id text author {id name username}}}"
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey("data", $data);
        $this->assertArrayHasKey("tweet", $data["data"]);
        $this->assertArrayHasKey("id", $data["data"]["tweet"]);
        $this->assertArrayHasKey("text", $data["data"]["tweet"]);
        $this->assertEquals("64bbde82c1223", $data["data"]["tweet"]["id"]);
        $this->assertArrayHasKey("author", $data["data"]["tweet"]);
    }

    public function testTimelineQuery()
    {
        $response = $this->client->post("", [
            "json" => [
                "query" => "query {timeline (userId: \"64bbde82c126e\") {id text author {username}}}"
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey("data", $data);
        $this->assertArrayHasKey("timeline", $data["data"]);
        $this->assertArrayHasKey("id", $data["data"]["timeline"][0]);
        $this->assertArrayHasKey("username", $data["data"]["timeline"][0]["author"]);
    }

    public function testDeleteTweetMutation()
    {
        $response = $this->client->post("", [
            "json" => [
                "query" => "mutation {deleteTweet (tweetId: \"64bbef615c46c\")}"
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey("data", $data);
        $this->assertTrue($data["data"]["deleteTweet"]);
    }
}
