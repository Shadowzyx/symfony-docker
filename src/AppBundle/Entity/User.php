<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 12/09/17
 * Time: 09:49
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Jérémy Lefebvre <jeremy2@widop.com>
 *
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type = "integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 100
     * )
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 100
     * )
     */
    protected $prenom;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
}