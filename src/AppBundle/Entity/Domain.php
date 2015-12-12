<?php

namespace AppBundle\Entity;

/**
 * Domain.
 */
class Domain
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fqdn;

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
     * Set fqdn.
     *
     * @param string $fqdn
     *
     * @return Domain
     */
    public function setFqdn($fqdn)
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * Get fqdn.
     *
     * @return string
     */
    public function getFqdn()
    {
        return $this->fqdn;
    }
}
