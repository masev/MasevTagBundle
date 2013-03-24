<?php

namespace Masev\TagBundle\FieldType\Tag\Gateway;

use RuntimeException;
use eZ\Publish\Core\Persistence\Legacy\EzcDbHandler;

class LegacyStorage
{
    protected $dbHandler;

    /**
     * Set database handler for this gateway
     *
     * @param mixed $dbHandler
     *
     * @return void
     * @throws RuntimeException if $dbHandler is not an instance of
     *         {@link \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler}
     */
    public function setConnection( $dbHandler )
    {
        // This obviously violates the Liskov substitution Principle, but with
        // the given class design there is no sane other option. Actually the
        // dbHandler *should* be passed to the constructor, and there should
        // not be the need to post-inject it.
        if ( !$dbHandler instanceof EzcDbHandler )
        {
            throw new RuntimeException( "Invalid dbHandler passed" );
        }

        $this->dbHandler = $dbHandler;
    }

    /**
     * Returns the active connection
     *
     * @throws RuntimeException if no connection has been set, yet.
     *
     * @return \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler
     */
    protected function getConnection()
    {
        if ( $this->dbHandler === null )
        {
            throw new RuntimeException( "Missing database connection." );
        }
        return $this->dbHandler;
    }
}
