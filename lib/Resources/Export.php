<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a export, providing access to its
 * attributes
 *
 * @property-read mixed $created_at
 * @property-read mixed $currency
 * @property-read mixed $download_url
 * @property-read mixed $export_type
 * @property-read mixed $id
 */
class Export extends BaseResource
{
    protected $model_name = "Export";

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when this
     * resource was created.
     */
    protected $created_at;

    /**
     * The currency of the export (if applicable)
     */
    protected $currency;

    /**
     * Download url for the export file. Subject to expiry.
     */
    protected $download_url;

    /**
     * The type of the export
     */
    protected $export_type;

    /**
     * Unique identifier, beginning with "EX".
     */
    protected $id;

}
