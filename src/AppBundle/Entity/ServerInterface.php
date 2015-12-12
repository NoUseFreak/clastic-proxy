<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

interface ServerInterface
{
    /**
     * @return ArrayCollection
     */
    public function getDomains();
}
