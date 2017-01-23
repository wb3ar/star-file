<?php
$entityManager = $this->entityManager;

$fileRepository = $entityManager->getRepository('Entity\File');
$files = $fileRepository->findBy(array(), array('date' => 'DESC'));

$tagsGataway = new Classes\TagsTableGataway($entityManager->getConnection());
$tags = $tagsGataway->getBiggestTags(10);

if (!empty($files)) {
return $this->view->render($response, 'files.html', ['files' => $files, 'tags' => $tags]);
}
else {
  $message = 'На файобменнике нет загруженных файлов.';

  return $this->view->render($response, 'message.html', ['message' => $message]);
}
