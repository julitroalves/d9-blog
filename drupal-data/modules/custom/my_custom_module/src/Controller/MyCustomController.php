<?php

namespace Drupal\my_custom_module\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\my_custom_module\Repository\ContactRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MyCustomController extends ControllerBase {

  protected ContactRepository $repository;

  public static function create(ContainerInterface $container): MyCustomController|static {
    $controller = new static($container->get('my_custom_module.contactrepository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }

  public function __construct(ContactRepository $repository) {
    $this->repository = $repository;
  }

  public function contactList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('Generate a list of entries')
    ];

    $rows = [];
    $headers = [
      $this->t('Id'),
      $this->t('Name'),
      $this->t('E-mail'),
      $this->t('Telephone'),
      $this->t('Age'),
    ];

    $entries = $this->repository->load();

    foreach ($entries as $entry) {
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', (array) $entry);
    }

    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => $this->t('There is no content.')
    ];

    $content['#cache']['max-age'] = 0;

    return $content;
  }

}
