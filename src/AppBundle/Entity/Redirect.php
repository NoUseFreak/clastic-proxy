<?php

namespace AppBundle\Entity;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Redirect.
 */
class Redirect implements NodeReferenceInterface, ServerInterface
{
    use NodeReferenceTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $target;

    /**
     * @var Domain[]
     */
    private $domains;

    /**
     * Proxy constructor.
     */
    public function __construct()
    {
        $this->domains = new ArrayCollection();
    }

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
     * Set target.
     *
     * @param string $target
     *
     * @return Redirect
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return ArrayCollection
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param Domain $domain
     */
    public function addDomain(Domain $domain)
    {
        $this->domains->add($domain);
    }

    /**
     * @param Domain $domain
     */
    public function removeDomain(Domain $domain)
    {
        $this->domains->removeElement($domain);
    }
}
