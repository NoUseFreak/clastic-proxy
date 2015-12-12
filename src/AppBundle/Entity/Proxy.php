<?php

namespace AppBundle\Entity;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Proxy
 */
class Proxy implements NodeReferenceInterface
{
    use NodeReferenceTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $backend;

    /**
     * @var integer
     */
    private $port;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Proxy
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set backend
     *
     * @param string $backend
     *
     * @return Proxy
     */
    public function setBackend($backend)
    {
        $this->backend = $backend;

        return $this;
    }

    /**
     * Get backend
     *
     * @return string
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * Set port
     *
     * @param integer $port
     *
     * @return Proxy
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
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
        $domain->setProxy($this);

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

