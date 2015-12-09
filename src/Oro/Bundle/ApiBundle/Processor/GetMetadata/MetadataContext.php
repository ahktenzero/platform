<?php

namespace Oro\Bundle\ApiBundle\Processor\GetMetadata;

use Oro\Bundle\ApiBundle\Metadata\MetadataExtraInterface;
use Oro\Bundle\ApiBundle\Processor\ApiContext;

class MetadataContext extends ApiContext
{
    /** FQCN of an entity */
    const CLASS_NAME = 'class';

    /** the configuration of an entity */
    const CONFIG = 'config';

    /** additional metadata information that should be retrieved */
    const EXTRA = 'extra';

    /** @var MetadataExtraInterface[] */
    protected $extras = [];

    public function __construct()
    {
        $this->set(self::EXTRA, []);
    }

    /**
     * Gets FQCN of an entity.
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->get(self::CLASS_NAME);
    }

    /**
     * Sets FQCN of an entity.
     *
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->set(self::CLASS_NAME, $className);
    }

    /**
     * Gets the configuration of an entity.
     *
     * @return array|null
     */
    public function getConfig()
    {
        return $this->get(self::CONFIG);
    }

    /**
     * Sets the configuration of an entity.
     *
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->set(self::CONFIG, $config);
    }

    /**
     * Checks if the specified additional metadata is requested.
     *
     * @param string $extraName
     *
     * @return bool
     */
    public function hasExtra($extraName)
    {
        return in_array($extraName, $this->get(self::EXTRA), true);
    }

    /**
     * Gets a list of requested additional metadata.
     *
     * @return MetadataExtraInterface[]
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Sets additional metadata that you need.
     *
     * @param MetadataExtraInterface[] $extras
     *
     * @throws \InvalidArgumentException if $extras has invalid elements
     */
    public function setExtras(array $extras)
    {
        $names = [];
        foreach ($extras as $extra) {
            if (!$extra instanceof MetadataExtraInterface) {
                throw new \InvalidArgumentException(
                    'Expected an array of "Oro\Bundle\ApiBundle\Metadata\MetadataExtraInterface".'
                );
            }
            $names[] = $extra->getName();
            $extra->configureContext($this);
        }

        $this->extras = $extras;
        $this->set(self::EXTRA, $names);
    }
}
