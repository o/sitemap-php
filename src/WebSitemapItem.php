<?php

namespace Osm\Sitemap;


class WebSitemapItem
{

    const DEFAULT_PRIORITY = 0.5;

    const CHANGE_FREQ_ALWAYS = 'always';
    const CHANGE_FREQ_HOURLY = 'hourly';
    const CHANGE_FREQ_DAILY = 'daily';
    const CHANGE_FREQ_WEEKLY = 'weekly';
    const CHANGE_FREQ_MONTHLY = 'monthly';
    const CHANGE_FREQ_YEARLY = 'yearly';
    const CHANGE_FREQ_NEVER = 'never';

    /**
     * @var string
     */
    private $location;

    /**
     * @var float
     */
    private $priority;

    /**
     * @var string
     */
    private $changeFrequency;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * WebSitemapItem constructor.
     * @param string $location
     */
    public function __construct($location = null)
    {
        if (null !== $location) {
            $this->location = $location;
        }
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return object $this 
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param float $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    /**
     * @param string $changeFrequency
     */
    public function setChangeFrequency($changeFrequency)
    {
        $this->changeFrequency = $changeFrequency;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }
    
}