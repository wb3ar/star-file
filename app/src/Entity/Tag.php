<?php

namespace Entity;

/**
  * @Entity @Table(name="tags")
  **/
 class Tag
 {
     /** @Id @Column(type="integer") @GeneratedValue **/
   private $id;
   /** @Column(type="string", unique=true) **/
   private $name;

    private $count;

   /**
    * Many Tags have Many Files.
    *
    * @ManyToMany(targetEntity="File", mappedBy="tags")
    */
   private $files;
    /**
     * Constructor.
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get counts.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Add file.
     *
     * @param \File $file
     *
     * @return Tag
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file.
     *
     * @param \File $file
     */
    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }
 }
