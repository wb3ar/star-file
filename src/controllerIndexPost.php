<?php
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' post route");

    $files = $request->getUploadedFiles();
    if (empty($files['newfile'])) {
        throw new Exception('Произошла ошибка. Возможно Вы пытаетесь загрузить файл размером больше 100 Мб.');
    }
    $newfile = $files['newfile'];
    if ($newfile->getError() !== UPLOAD_ERR_OK) {
        throw new Exception('Произошла ошибка при загрузке файла');
    }
    $uploadFileName = $newfile->getClientFilename();

    $file = new Entity\File($uploadFileName);
    $entityManager = $this->entityManager;
    $entityManager->persist($file);
    $entityManager->flush();

    preg_match('/.\\w+$/', $file->getName(), $match);
    $convertedID = $file->getConvertedId();
    $fileBasePath = $file->makeDir('uploads') . $convertedID;
    $filePath = $fileBasePath . $match[0];
    $newfile->moveTo($filePath);

    $fileAnalyzer = new Classes\FileAnalyzer(new getID3());
    $fileInfo = $fileAnalyzer->analyzeFile($filePath);
      if (preg_match('/image/', $fileInfo['mime_type'])) {
          $file->setHavePreview();
          $image = new \Imagick(realpath($filePath));
          if ($image->getImageHeight() > 300 or $image->getImageWidth() > 500) {
              $image->cropThumbnailImage(500, 300);
          }
          file_put_contents($file->makeAndGetPreviewDir(), $image);
      } elseif (preg_match('/video/', $fileInfo['mime_type'])) {
          $file->setIsVideo();
          $arrVideoPaths = $file->makeAndGetVideosPaths();
          var_dump ($arrVideoPaths);
          exit; 
          $ffmpeg = $this->ffmpeg;
          $video = $ffmpeg->open($filePath);
          $video
    ->save(new FFMpeg\Format\Video\X264('libmp3lame', 'libx264'), 'export-x264.mp4')
    ->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv')
    ->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm');
      }
    rename($filePath, $fileBasePath.'.txt');
    $file->setMediaInfo($fileInfo);
    $entityManager->persist($file);
    $entityManager->flush();

    $_SESSION['convertedID'] = $convertedID;
    $_SESSION['fileName'] = $uploadFileName;

    return $response->withHeader('Location', '/');
