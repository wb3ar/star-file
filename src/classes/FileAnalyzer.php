<?php

namespace Classes;

/**
 * Класс, для анализа файла с помощью getID3.
 */
class FileAnalyzer
{
    private $getid;
    private $mediaInfo;

    /**
     * Класс GetID3 внедряется через конструктор
     */
    public function __construct($getid = null)
    {
        $this->getid = $getid;
    }

    /**
     * Получить методанные о файле.
     */
    public function analyzeFile($filePath)
    {
        $this->getid->encoding = 'UTF-8';
        $arrayInfo = $this->getid->analyze($filePath);
        \getid3_lib::CopyTagsToComments($arrayInfo);
        // echo '<pre>';
        // print_r($arrayInfo);
        // echo '</pre>';
        // exit;
        $this->createMediaInfo($arrayInfo);

        return $this->getMediaInfo();
    }

    public function createMediaInfo($arrayInfo)
    {
        $this->mediaInfo['filesize'] = (isset($arrayInfo['filesize']) ? $arrayInfo['filesize'] : '');
        $this->mediaInfo['human_filesize'] = $this->getHumanFileSize();
        $this->mediaInfo['mime_type'] = (isset($arrayInfo['mime_type']) ? $arrayInfo['mime_type'] : '');
        $this->mediaInfo['playtime_string'] = (isset($arrayInfo['playtime_string']) ? $arrayInfo['playtime_string'] : '');
        if (isset($arrayInfo['audio'])) {
            $this->mediaInfo['audio']['format_name'] = (isset($arrayInfo['audio']['dataformat']) ? $arrayInfo['audio']['dataformat'] : '');
            $this->mediaInfo['audio']['encoder_options'] = (isset($arrayInfo['audio']['encoder_options']) ? $arrayInfo['audio']['encoder_options'] : '');
            $method = (isset($arrayInfo['audio']['dataformat']) ? $arrayInfo['audio']['dataformat'] : '').'Info';
            if ($method && method_exists($this, $method)) {
                $this->$method();
            }
        }
        if (isset($arrayInfo['video'])) {
            $this->mediaInfo['video']['format_name'] = (isset($arrayInfo['video']['dataformat']) ? $arrayInfo['video']['dataformat'] : '');
            $this->mediaInfo['video']['resolution'] = (isset($arrayInfo['video']['resolution_x'], $arrayInfo['video']['resolution_y'])) ? $arrayInfo['video']['resolution_x'].'x'.$arrayInfo['video']['resolution_y'] : '';
            $this->mediaInfo['video']['bits_per_sample'] = (isset($arrayInfo['video']['bits_per_sample'])) ? $arrayInfo['video']['bits_per_sample'] : '';
            $method = (isset($arrayInfo['video']['dataformat']) ? $arrayInfo['video']['dataformat'] : '').'Info';
            if ($method && method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    public function setMediaInfo($mediaInfo)
    {
        $this->mediaInfo = $mediaInfo;
    }

    public function getMediaInfo()
    {
        return $this->mediaInfo;
    }

    /**
     * post-getID3() data handling for AAC files.
     */
    private function aacInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'AAC';
    }

    /**
     * post-getID3() data handling for Wave files.
     */
    private function riffInfo()
    {
        if ($this->mediaInfo['audio']['dataformat'] == 'wav') {
            $this->mediaInfo['audio']['format_name'] = 'Wave';
        } elseif (preg_match('#^mp[1-3]$#', $this->mediaInfo['audio']['dataformat'])) {
            $this->mediaInfo['audio']['format_name'] = strtoupper($this->mediaInfo['audio']['dataformat']);
        } else {
            $this->mediaInfo['audio']['format_name'] = 'riff/'.$this->mediaInfo['audio']['dataformat'];
        }
    }

    /**
     * * post-getID3() data handling for FLAC files.
     */
    private function flacInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'FLAC';
    }

    /**
     * post-getID3() data handling for Monkey's Audio files.
     */
    private function macInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'Monkey\'s Audio';
    }

    /**
     * post-getID3() data handling for Lossless Audio files.
     */
    private function laInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'La';
    }

    /**
     * post-getID3() data handling for Ogg Vorbis files.
     */
    private function oggInfo()
    {
        if ($this->mediaInfo['audio']['dataformat'] == 'vorbis') {
            $this->mediaInfo['audio']['format_name'] = 'Ogg Vorbis';
        } elseif ($this->mediaInfo['audio']['dataformat'] == 'flac') {
            $this->mediaInfo['audio']['format_name'] = 'Ogg FLAC';
        } elseif ($this->mediaInfo['audio']['dataformat'] == 'speex') {
            $this->mediaInfo['audio']['format_name'] = 'Ogg Speex';
        } else {
            $this->mediaInfo['audio']['format_name'] = 'Ogg '.$this->mediaInfo['audio']['dataformat'];
        }
    }

    /**
     * post-getID3() data handling for WMA files.
     */
    private function wmaInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'WMA (Windows Media Audio)';
    }

    /**
     * post-getID3() data handling for Musepack files.
     */
    private function mpcInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'Musepack';
    }

    /**
     * post-getID3() data handling for MPEG files.
     */
    private function mp3Info()
    {
        $this->mediaInfo['audio']['format_name'] = 'MP3';
    }

    /**
     * post-getID3() data handling for MPEG files.
     */
    private function mp2Info()
    {
        $this->mediaInfo['audio']['format_name'] = 'MP2';
    }

    /**
     * post-getID3() data handling for MPEG files.
     */
    private function mp1Info()
    {
        $this->mediaInfo['audio']['format_name'] = 'MP1';
    }

    /**
     * post-getID3() data handling for WMA files.
     */
    private function asfInfo()
    {
        $this->mediaInfo['audio']['format_name'] = strtoupper($this->mediaInfo['audio']['dataformat']);
    }

    /**
     * post-getID3() data handling for Real files.
     */
    private function realInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'Real';
    }

    /**
     * post-getID3() data handling for VQF files.
     */
    private function vqfInfo()
    {
        $this->mediaInfo['audio']['format_name'] = 'VQF';
    }

    /**
     * post-getID3() data handling for PNG files.
     */
    private function pngInfo()
    {
        $this->mediaInfo['video']['format_name'] = 'PNG (Portable Network Graphics)';
    }

    /**
     * post-getID3() data handling for JPG files.
     */
    private function jpgInfo()
    {
        $this->mediaInfo['video']['format_name'] = 'JPEG (Joint Photographic Experts Group)';
    }

    /**
     * post-getID3() data handling for BMP files.
     */
    private function bmpInfo()
    {
        $this->mediaInfo['video']['format_name'] = 'BMP (Bitmap Picture)';
    }

    /**
     * post-getID3() data handling for WMV files.
     */
    private function wmvInfo()
    {
        $this->mediaInfo['video']['format_name'] = 'WMV (Windows Media Video)';
    }

    public function getHumanFileSize()
    {
        $fileSize=$this->mediaInfo['filesize'];
        $sz = 'BKMGTP';
        $factor = floor((strlen($fileSize) - 1) / 3);

        return sprintf('%.2f', $fileSize / pow(1024, $factor)).@$sz[$factor];
    }
}
