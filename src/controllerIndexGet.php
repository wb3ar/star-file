<?php

// Sample log message
$this->logger->info("Slim-Skeleton '/' route");

if (isset($_SESSION['convertedID'], $_SESSION['fileName'])) {
    $convertedID = $_SESSION['convertedID'];
    $fileName = $_SESSION['fileName'];
    session_unset();

    return $this->view->render($response, 'edit.html', ['convertedID' => $convertedID, 'fileName' => $fileName, 'scheme' => $request->getServerParam('REQUEST_SCHEME'), 'host' => $request->getServerParam('HTTP_HOST')]);
} else {

// Render index view
return $this->view->render($response, 'index.html');
}
