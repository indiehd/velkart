<?php

namespace IndieHD\Velkart\Contracts\Repositories\Session;

interface CartSessionRepositoryContract
{
    /**
     * Destroy Cart data within the session.
     */
    public function destroy(): void;
}
