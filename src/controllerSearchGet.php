<?php

$query = $request->getQueryParam('q');
$sphinx = $this->sphinx;
$sphinx->setMatchMode(SPH_MATCH_EXTENDED);
$result = $sphinx->query($query);

/* Установка внутренней кодировки в UTF-8 */
mb_internal_encoding('UTF-8');

if (!isset($query) || mb_strlen($query) < 3) {
    $message = 'Для поиска необходимо ввести не менее 3 символов.';

    return $this->view->render($response, 'message.html', ['message' => $message, 'query' => $query]);
} elseif (isset($result['matches'])) {
    $array_ids = array_keys($result['matches']);

    $entityManager = $this->entityManager;
    $fileRepository = $entityManager->getRepository('File');
    $files = $fileRepository->findby(array('id' => $array_ids));

    return $this->view->render($response, 'files.html', ['files' => $files, 'query' => $query]);
}
else {
  $message = 'Ничего не найдено по вашему запросу.';

  return $this->view->render($response, 'message.html', ['message' => $message, 'query' => $query]);
}
