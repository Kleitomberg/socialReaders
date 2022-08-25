<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait Timestamp
{
    /**
     * @ORM\Column(type="datetime")
     */
    #[ORM\Column(type: "datetime")]
    private $criadoEm;

    /**
     * @return mixed
     */
    public function getCriadoEm()
    {
        return $this->criadoEm;
    }

    /**
     * @ORM\PrePersist()
     */

     #[ORM\PrePersist]
    public function prePersist()
    {
        $this->criadoEm = new \DateTime();
    }
}
