<?php

use Aws\DynamoDb\DynamoDbClient;
use Aws\Exception\DynamoDbException;

class DynamoDBClientFactory
{
    public static function create(): DynamoDbClient
    {
      return new DynamoDbClient([
          'region' => 'us-east-1',
          'version' => 'latest',
          'credentials' => [
              'key' => $_ENV["AWS_KEY"],
              'secret' => $_ENV["AWS_SECRET"],
          ],
      ]);
    }
}
