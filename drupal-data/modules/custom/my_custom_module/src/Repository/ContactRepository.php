<?php

namespace Drupal\my_custom_module\Repository;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityRepository;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

class ContactRepository extends EntityRepository {

  use MessengerTrait;
  use StringTranslationTrait;

  protected $connection;

  public function __construct(Connection $connection, TranslationInterface $translation, MessengerInterface $messenger) {
    $this->connection = $connection;
    $this->setMessenger($messenger);
    $this->setStringTranslation($translation);
  }

  public function load(array $conditions = []): array {
    $select = $this->connection->select('my_custom_module_contacts')->fields('my_custom_module_contacts');

    foreach ($conditions as $field => $value) {
      $select->condition($field, $value);
    }

    return $select->execute()->fetchAll();
  }

  public function insert() {}
  public function update() {}
  public function delete() {}
}
