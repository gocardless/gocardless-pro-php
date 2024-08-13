<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a transferred_mandate, providing access to its
 * attributes
 *
 * @property-read mixed $encrypted_customer_bank_details
 * @property-read mixed $encrypted_decryption_key
 * @property-read mixed $links
 * @property-read mixed $public_key_id
 */
class TransferredMandate extends BaseResource
{
    protected $model_name = "TransferredMandate";

    /**
     * Encrypted customer bank account details, containing:
     * `iban`, `account_holder_name`, `swift_bank_code`, `swift_branch_code`,
     * `swift_account_number`
     */
    protected $encrypted_customer_bank_details;

    /**
     * Random AES-256 key used to encrypt bank account details, itself encrypted
     * with your public key.
     */
    protected $encrypted_decryption_key;

    /**
     * 
     */
    protected $links;

    /**
     * The ID of an RSA-2048 public key, from your JWKS, used to encrypt the AES
     * key.
     */
    protected $public_key_id;

}
