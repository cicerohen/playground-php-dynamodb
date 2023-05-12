<?php

use Aws\DynamoDb\DynamoDbClient;
use Aws\Exception\DynamoDbException;

require_once  __DIR__ . "/DynamoDBClientFactory.php";
require_once __DIR__ . "/ToDoDTO.php";

class ToDoDAO extends DynamoDBClientFactory
{
  private string $tableName;
  private DynamoDbClient $client;

  public function __construct()
  {
    $this->tableName = "ToDo";
    $this->client = self::create();
  }

  public function getItems()
  {

      $params = [
        "TableName" => $this->tableName,
      ];

      $result = $this->client->scan($params);
      $items =  $result->toArray()["Items"];
      $todos = [];

      foreach ($items as $item) {
        $todo = new ToDoDTO();
        $todo->setId($item["id"]["S"]);
        $todo->setTitle($item["title"]["S"]);
        $todo->setDescription($item["description"]["S"]);
        $todos[] = $todo;
      }

      return  $todos;

  }

  public function getItem(ToDoDTO $todo)
  {

    $params = [
      "TableName" => $this->tableName,
      "Key" => [
        "id" => ["S" => $todo->getId()],
      ],
    ];

    $result = $this->client->getItem($params);
    $item = $result->toArray()["Item"] ?? [];

    $toDoDTO = new ToDoDTO();
    $toDoDTO->setId($item["id"]["S"] ?? "");
    $toDoDTO->setTitle($item["title"]["S"] ?? "");
    $toDoDTO->setDescription($item["description"]["S"] ?? "");

    return $toDoDTO;

  }

  public function addItem(ToDoDTO $todo)
  {
    $params = [
      "TableName" => $this->tableName,
      "Item" => [
        "id" => ["S" => uniqid()],
        "title" => ["S" => $todo->getTitle()],
        "description" => ["S" => $todo->getDescription()],
      ],
      'ReturnValues' => 'ALL_OLD'
    ];

    $this->client->putItem($params);

  }

  public function updateItem(ToDoDTO $todo)
  {

    $params = [
      "TableName" => $this->tableName,
      "Key" => [
        "id" => [ "S" => $todo->getId() ]
      ],
      "UpdateExpression" => "set #t = :title, #d = :description",
      "ExpressionAttributeNames" => [
        "#t" => "title",
        "#d" => "description"
      ],
      "ExpressionAttributeValues" => [
        ":title" => ["S" => $todo->getTitle()],
        ":description" => ["S" => $todo->getDescription()]
      ],
      "ReturnValues" => "ALL_NEW"
    ];

    $result = $this->client->updateItem($params);

    $toDoDTO = new ToDoDTO();

    $toDoDTO->setId($result["Attributes"]["id"]["S"] ?? "");
    $toDoDTO->setTitle($result["Attributes"]["title"]["S"] ?? "");
    $toDoDTO->setDescription($result["Attributes"]["description"]["S"] ?? "");

    return $toDoDTO;

  }

  public function deleteItem(ToDoDTO $todo)
  {
    $params = [
      "TableName" => $this->tableName,
      "Key" => [
        "id" => [ "S" => $todo->getId() ]
      ],
    ];

    $this->client->deleteItem($params);
  }

}
