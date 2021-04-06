<?php

namespace App\Entity;

use App\Repository\ProductTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Xiidea\EasyAuditBundle\Annotation\SubscribeDoctrineEvents;

/**
 * @ORM\Entity(repositoryClass=ProductTypeRepository::class)
 * @SubscribeDoctrineEvents(events = "created,deleted")
 */
class ProductType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }


    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Generates the magic method
     *
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->type;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
