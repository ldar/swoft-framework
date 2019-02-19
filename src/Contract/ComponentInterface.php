<?php

namespace Swoft\Contract;

use Swoft\Annotation\LoaderInterface;

/**
 * Interface ComponentInterface
 * @since 2.0
 */
interface ComponentInterface extends DefinitionInterface, LoaderInterface
{
    /**
     * Disable or enable this component.
     *
     * @return bool
     */
    public function enable(): bool;

    /**
     * Metadata information for the component
     *
     * @return array
     * [
     *  'name'        => 'user/package', // same composer.json -> name
     *  'title'       => 'my component',
     *  'version'     => '1.0.0',
     *  'authors'     => [
     *      [
     *          'name' => 'tom',
     *          'homepage' => 'https://github.com/tom'
     *      ]
     *  ],
     *  'createAt'    => '2019.02.12',
     *  'updateAt'    => '2019.04.12',
     *  'description' => 'description for the component',
     *  'homepage'    => 'https://github.com/inhere/some-component',
     * ]
     */
    public function getMetadata(): array;
}