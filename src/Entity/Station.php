<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *   itemOperations={
 *      "get"={"method"="GET"},
 *      "put"={"method"="PUT"},
 *      "delete"={"method"="DELETE"},
 *      "getList"={
 *        "route_name"="get_stations_by_radius",
 *        "swagger_context" = {
 *          "parameters" = {
 *            {
 *              "name" = "latitude",
*               "in" = "path",
 *              "required" = "true",
 *              "type" = "string"
 *            },
*              {
 *              "name" = "longitude",
 *              "in" = "path",
 *              "required" = "true",
 *              "type" = "string"
 *            },
*              {
 *              "name" = "kilometers",
 *              "in" = "path",
 *              "required" = "true",
 *              "type" = "string"
 *            }
 *          },
 *          "responses" = {
 *            "200" = {
 *              "description" = "The list of Stations by radius of n kilometers from a point (latitude, longitude) ordered by distance"
 *            }
 *          }
 *        }
 *      }
 *   }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StationRepository")
 */
class Station
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $companyId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="stations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    public function setCompanyId(int $companyId): self
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function getCompany(): ?company
    {
        return $this->company;
    }

    public function setCompany(?company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
