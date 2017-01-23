<?php

namespace Classes;

/**
 * Класс, содержащий методы для работы с таблицей тегов.
 */
class TagsTableGataway
{
  private $conn;
    /**
     * Объект для работы с БД внедряется через конструктор
     */
    public function __construct($conn) {
      $stmt = $this->conn = $conn;
    }

    /**
     * Получить массив тегов, добавленных к наибольшиму колличеству файлов
     */
    public function getBiggestTags($limit) {
      $sql ='select id, name, count(tag_id) as count from tags join files_tags on tag_id=id group by name order by count desc limit '.$limit;
      $stmt=$this->conn->query($sql);
      $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'Entity\Tag');
      return $result;
    }
}
