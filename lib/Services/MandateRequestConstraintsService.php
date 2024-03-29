<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Services;

use \GoCardlessPro\Core\Paginator;
use \GoCardlessPro\Core\Util;
use \GoCardlessPro\Core\ListResponse;
use \GoCardlessPro\Resources\MandateRequestConstraints;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the MandateRequestConstraints
 * endpoints of the API
 */
class MandateRequestConstraintsService extends BaseService
{

    protected $envelope_key   = 'mandate_request_constraints';
    protected $resource_class = '\GoCardlessPro\Resources\MandateRequestConstraints';


}
