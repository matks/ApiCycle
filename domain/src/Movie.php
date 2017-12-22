<?php

namespace ApiCycle\Domain;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="ApiCycle\Domain\MovieRepository")
 * @UniqueEntity("name")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Movie
{
    const STATUS_VALID = 'valid';
    const STATUS_DELETED = 'deleted';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @Serializer\Groups({"movie", "all"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @Serializer\Expose
     * @Serializer\Groups({"all"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"movie", "all"})
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"all"})
     */
    private $status;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->createdAt = new \DateTime();
        $this->status = self::STATUS_VALID;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $name
     *
     * @return Movie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function delete()
    {
        $this->status = self::STATUS_DELETED;
        $this->deletedAt = new \DateTime();
    }
}
