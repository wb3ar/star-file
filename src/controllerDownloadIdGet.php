<?php

if (isset($_SESSION['filePath'], $_SESSION['name'], $_SESSION['mime_type'], $_SESSION['filesize']) && $_SESSION['id'] === $args['id']) {
    $file = getcwd() . DIRECTORY_SEPARATOR . $_SESSION['filePath'];
    return $response->withHeader('X-Sendfile', $file)
->withHeader('Content-Type', $_SESSION['mime_type'])
->withHeader('Content-Disposition', 'attachment;filename="'.$_SESSION['name'].'"')
->withHeader('Content-Length', $_SESSION['filesize']);
} else {
  return $response->withHeader('Location', '/'.$args['id']);
}
