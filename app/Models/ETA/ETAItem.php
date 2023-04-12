<?php

namespace App\Models\ETA;

/**
 * Eloquent class to describe the ETAItems table.
 *
 * automatically generated by ModelGenerator.php
 */
class ETAItem extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'ETAItems';

    public $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = ['codeUsageRequestID', 'codeTypeName', 'codeID', 'itemCode', 'codeNamePrimaryLang',
        'codeNameSecondaryLang', 'descriptionPrimaryLang', 'descriptionSecondaryLang', 'parentCodeID', 'parentItemCode',
        'parentCodeNamePrimaryLang', 'parentCodeNameSecondaryLang', 'parentLevelName', 'levelName',
        'requestCreationDateTimeUtc', 'codeCreationDateTimeUtc', 'activeFrom', 'activeTo', 'active', 'status', 'statusReason',
        'ownerTaxpayerrin', 'ownerTaxpayername', 'ownerTaxpayernameAr', 'requesterTaxpayerrin', 'requesterTaxpayername',
        'requesterTaxpayernameAr', 'codeCategorizationlevel1id', 'codeCategorizationlevel1name',
        'codeCategorizationlevel1nameAr', 'codeCategorizationlevel2id', 'codeCategorizationlevel2name',
        'codeCategorizationlevel2nameAr', 'codeCategorizationlevel3id', 'codeCategorizationlevel3name',
        'codeCategorizationlevel3nameAr', 'codeCategorizationlevel4id', 'codeCategorizationlevel4name',
        'codeCategorizationlevel4nameAr'];

    public function getDates()
    {
        return ['requestCreationDateTimeUtc', 'codeCreationDateTimeUtc', 'activeFrom', 'activeTo'];
    }
}
