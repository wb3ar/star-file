<?php

// Sample log message
$this->logger->info("Slim-Skeleton '/{id}' post route");

$data = $request->getParsedBody();
$description = filter_var($data['description'], FILTER_SANITIZE_STRING);
$tagsNames = filter_var($data['tags'], FILTER_SANITIZE_STRING);
$id = gmp_strval(gmp_init($args['id'], 62), 10);
$entityManager = $this->entityManager;
$file = $entityManager->find('Entity\File', $id);
$file->setDescription($description);
if (!empty($tagsNames)) {
    $arrTagsNames = explode(',', $tagsNames);
    $tagsRepository = $entityManager->getRepository('Entity\Tag');
    foreach ($arrTagsNames as $tagName) {
        $tagName=trim($tagName);
        $tag = $tagsRepository->findOneBy(array('name' => $tagName));
        if (empty($tag)) {
            $tag = new Entity\Tag($tagName);
        }
        $file->addTag($tag);
        $entityManager->persist($tag);
    }
}
    $entityManager->flush();

return $response->withHeader('Location', '/'.$args['id']);
