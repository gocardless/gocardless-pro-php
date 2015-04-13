<?php

namespace GoCardless;

/**
  * Class constaining constants to determine which server the api client should call.
  */
class Environment
{
	/** The production GoCardless environment to use when billing is involved after development. */
    const PRODUCTION = 'https://api.gocardless.com/';

    /** A staging server with production data, allowing for testing code against the edge of gocardless. */
    const STAGING    = 'https://api-staging.gocardless.com/';

    /** The sandbox testing server, seperate dataset and no ability to make "real" transactions. */
    const SANDBOX    = 'https://api-sandbox.gocardless.com/';
}
