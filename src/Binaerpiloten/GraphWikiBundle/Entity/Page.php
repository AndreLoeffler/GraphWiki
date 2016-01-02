<?php

namespace Binaerpiloten\GraphWikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Binaerpiloten\GraphWikiBundle\Repository\PageRepository")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
	/**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    protected $creator;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="editor_id", referencedColumnName="id")
     */
    protected $editor;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="last", type="datetime")
     */
    
    protected $last;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setCreator($creator)
    {
    	$this->creator = $creator;
    	$this->editor = $creator;
    	$this->last = new \DateTime('now');
    	return $this;
    }
    
    public function getCreator() 
    {
    	return $this->creator;
    }
    public function setEditor($editor)
    {
    	$this->editor = $editor;
    	$this->last = new \DateTime('now');
    	return $this;
    }
    
    public function getEditor()
    {
    	return $this->editor;
    }
    
    public function setLast($last) 
    {
    	$this->last = $last;
    	
    	return $this;
    }
    public function getLast()
    {
    	return $this->last;
    	 
    }
    
}

