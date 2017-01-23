<?php

namespace Entity;

/**
 * @Entity @Table(name="files")
 **/
class File
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string") **/
    private $name;
    /** @Column(type="datetime") **/
    private $date;
    /** @Column(type="string", length=510, nullable=true) **/
    private $description;
    /** @Column(type="json_array", nullable=true) **/
    private $mediaInfo;
    /** @Column(type="boolean") **/
    private $havePreview;
    /** @Column(type="boolean") **/
    private $isVideo;

    /**
     * Many Files have Many Tags.
     *
     * @var Collection
     * @ManyToMany(targetEntity="Tag")
     */

     /**
 * Many Files have Many Tags.
 * @ManyToMany(targetEntity="Tag", inversedBy="files")
 * @JoinTable(name="files_tags")
 */
    private $tags;

    /**
     * Constructor
     */
     public function __construct($name)
    {
        $this->name = $name;
        $this->date = new \DateTime();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->havePreview = false;
        $this->isVideo = false;
    }

    public function getConvertedId()
    {
        return gmp_strval($this->id, 62);
    }

    public function makeDir($dir)
    {
      $dirPath=$dir.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        if (!is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                throw new Exception('Не удалось создать директории');
            }
        }
        return $dirPath;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return File
     */
    public function setMediaInfo($mediaInfo)
    {
        $this->mediaInfo = $mediaInfo;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getMediaInfo()
    {
        return $this->mediaInfo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return File
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return File
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add tag
     *
     * @param \Tag $tag
     *
     * @return File
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }


    /**
     * Get File Path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->getDatePath('uploads').$this->getConvertedId().'.txt';
    }

    /**
     * Set description
     *
     *
     */
    public function setHavePreview()
    {
        $this->havePreview = true;
    }

    /**
     * Get Preview value
     *
     * @return integer
     */
    public function getHavePreview()
    {
        return $this->havePreview;
    }

    public function makeAndGetPreviewDir()
    {
      preg_match("/.\\w+$/", $this->name, $match);
      return $this->makeDir('previews').$this->getConvertedId().$match[0];
    }

    /**
     * Get Date Path
     *
     * @return string
     */
    public function getDatePath($dir)
    {
      $date = $this->date;
      return '/'.$dir.'/'.$date->format('Y').'/'.$date->format('m').'/'.$date->format('d').'/';
    }

    /**
     * Get Preview Path
     *
     * @return string
     */
    public function getPreviewPath()
    {
      preg_match("/.\\w+$/", $this->name, $match);
      return $this->getDatePath('previews').$this->getConvertedId().$match[0];
    }

    /**
     * Set isVideo value
     *
     *
     */
    public function setIsVideo()
    {
        $this->isVideo = true;
    }

    /**
     * Get isVideo value
     *
     * @return integer
     */
    public function getIsVideo()
    {
        return $this->isVideo;
    }

    public function makeAndGetVideosPaths() {
      $basePath=$this->makeDir('video').$this->getConvertedId();
      return array($basePath.'.ogv', $basePath.'.mp4', $basePath.'.webm');
    }
}
