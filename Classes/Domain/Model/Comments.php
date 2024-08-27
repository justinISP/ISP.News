<?php
namespace ISP\News\Domain\Model;

/*
 * This file is part of the ISP.News package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Comments
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(length=10000)
     */
    protected $comment;

    /**
     * @var integer
     */
    protected $deleted;

    /**
     * @var \DateTime $created
     */
    protected $created;

    /**
     * @var string
     */
    protected $node;


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    /**
     * @return integer
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param integer $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return void
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }
    /**
     * @return string
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param string $node
     * @return void
     */
    public function setNode($node)
    {
        $this->node = $node;
    }
}
