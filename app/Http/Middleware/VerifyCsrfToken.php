<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = ['api/login',
        'api/getAllCustomFields',
        'api/getAllAdditionalFields',
        'api/addList',
        'api/getLists',
        'api/getListDetail',
        'api/deleteList',
        'api/duplicateList',
        'api/getCustomFields',
        'api/getUserLists',
        'api/addCustomFields',
        'api/getCustomFieldDetail',
        'api/deleteCustomField',
        'api/getCountries',
        'api/getListCustomFields',
        'api/splitList',
        'api/applySenderID',
        'api/getSenderids',
        'api/deleteSenderID',
        'api/getSenderIDDetail',
        'api/getBroadcasts',
        'api/getAllSenderIDs',
        'api/createBroadcast',
        'api/register',
        'api/refresh-token',
        'api/verify_token',
        'api/getImportStatus',
        'api/getContacts',
        'api/addContact',
        'api/importContactsStep1',
        'api/importContactsStep2',
        'api/exportListStep1',
        'api/exportListStep2',
        'api/getContactDetail',
        'api/suppressContacts',
        'api/getSuppressContacts',
        'api/getUploadSupressfiles',
        'api/deleteContacts',
        'api/getAdditionalFields',
        'api/getBroadcastDetail',
        'api/scheduleBroadcast',
        'api/getScheduleBroadcasts',
        'api/getScheduleBroadcastDetail',
        'api/deleteScheduleBroadcast',
        'api/getBroadcastStats',
        'api/getBroadcastSummary',
        'api/getScheduledBroadcastStats',
        'api/getCountrySentStats',
        'api/getTrasactionalStats',
        'api/getGlobalStats',
        'api/generateAPIToken',
        'api/getTransactionalTokens',
        'api/deleteTransactionalToken',
        'api/getActivityLogs',
        'api/getLoginLogs',
        'api/quickSendSMS',
        'api/getUserImportFiles',
        'api/getContactsByList',
        'api/clientLogoutActivity',
        'api/deleteSupressContact',
        'api/getExportFilesList',
        'api/downloadExportedFile',
        'api/profileUpdate',
        'api/sendMobileVerificationCode',
        'api/verifyMobileVerificationCode',
        'api/uploadUserDocument',       
        'api/getUserDocuments',
        'api/downloadUserFile',
        'addCustomSMSProvider',
        'api/getCustomSMSProviders',
        'api/addCustomProviderSenderID',
        'api/deleteBroadcast',
        'api/getAllBroadcast',
        'api/changeBroadcastStatus',
        'api/createClientFromWHMCS',
        'api/terminateClient',
        'api/changeClientStatus',
        'api/getClientDetailByEmail',
        'api/changeClientPassword',
        'api/deleteThirdPartySMSProvider',
        'api/getThirdPartySMSProviders',
        'api/addThirdPartySMSProvider',
        'api/getProviderDetail',
        'api/getUserSMSProviders',
        'api/addThirdPartyProviderSenderID',
        'api/getClientNotifications',
        'api/getLatestClientNotifications',
        'api/getBroadcastCost',
        'api/getContactsCount',
        'api/getClientBalance',
        'api/adminLoginAsUser',
        'api/getChartStats',
        'api/sendEmailResetPasswordLink',
        'api/resetPassword',
        'api/getUserName',
        'api/getActiveSenderIDs',
        'api/getClientDetail',
        'api/addCreditCard',
        'api/getPaymentMethod',
        'api/changeTimeZone',
        'api/payInvoice',
        'api/changePassword',
        'api/changeProfilePhoto',
        'api/getPackages',
        'api/deleteDocument',
        'api/getClientDestinationCountries',
        'api/getRequestCountries',
        'api/getCountryPrices',
        'api/applyForDestinationCountries',
        'api/getClientInvoices',
        'api/addBalance',
        'api/changePackageRequest',
        'api/payChangePackageInvoice',
        'api/changeClientPackage',
        'api/sendIndividualMessage',
        'webhooks'
    ];

}
