<?php
// Sample log message
$this->logger->info("Slim-Skeleton '/".$args['id']."' route");

$id = gmp_strval(gmp_init($args['id'], 62), 10);
$entityManager = $this->entityManager;
$file = $entityManager->find('Entity\File', $id);
$arrayInfo=$file->getMediaInfo();
$_SESSION['filePath'] = $file->getFilePath();
$_SESSION['name'] = $file->getName();
$_SESSION['id'] = $args['id'];
$_SESSION['filesize'] = $arrayInfo['filesize'];
$_SESSION['mime_type'] = $arrayInfo['mime_type'];
return $this->view->render($response, 'download.html', ['convertedID' => $args['id'], 'file' => $file, 'tags' => $file->getTags()->toArray(), 'mediaInfo' => $arrayInfo]);
