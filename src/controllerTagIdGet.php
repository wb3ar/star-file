<?php

// Sample log message
$this->logger->info("Slim-Skeleton '/tag/{id}' route");
$id=$args['id'];
$entityManager = $this->entityManager;
$tag = $entityManager->find('Entity\Tag', $id);
$files= $tag->getFiles()->toArray();
$countFiles=count($files);

$tagsGataway = new Classes\TagsTableGataway($entityManager->getConnection());
$tags = $tagsGataway->getBiggestTags(10);

// Render index view
return $this->view->render($response, 'files.html', ['files' => $tag->getFiles()->toArray(), 'message1' => $tag->getName(), 'message2' => $countFiles, 'tags' => $tags]);
