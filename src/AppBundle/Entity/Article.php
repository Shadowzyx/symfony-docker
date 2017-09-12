<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Jérémy Lefebvre <jeremy2@widop.com>
 * 
 * @ORM\Entity(repositoryClass = "AppBundle\Repository\ArticleRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name = "articles_title_unique", columns = {"title"})})
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type = "integer")
     *
     * @Groups({"comment", "article"})
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 100
     * )
     *
     * @Assert\NotBlank
     *
     * @Groups({"comment", "article"})
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type = "string")
     *
     * @Assert\NotBlank
     *
     * @Groups({"comment", "article"})
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 100
     * )
     *
     * @Assert\NotBlank
     *
     * @Groups({"comment", "article"})
     */
    protected $author;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity = "Comment", mappedBy = "article")
     *
     * @Groups({"article"})
     */
    protected $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }
}