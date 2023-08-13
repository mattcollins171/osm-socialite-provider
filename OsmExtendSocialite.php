<?php

namespace SocialiteProviders\osm;

use SocialiteProviders\Manager\SocialiteWasCalled;

class OsmExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('osm', Provider::class);
    }
}
