<?php 

namespace Masev\TagBundle\FieldType\Tag;

class TagService
{
    protected $tagStorage;

    public function __construct( $tagStorage )
    {
        $this->tagStorage = $tagStorage;
    }
}
