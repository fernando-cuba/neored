<?php

include_once 'config/config.php';

class serviceSendNotification
{
    private $EmailAddress;
    private $FirstName;
    private $message;
    private $ACCOUNT;
    private $USER;
    private $PASSWORD;
    private $MAILING_ID;


    public function __CONSTRUCT($EmailAddress__value, $FirstName__value, $message__value)
    {
        // ? Setting data to send email notification
        $this->EmailAddress = $EmailAddress__value;
        $this->FirstName = $FirstName__value;
        $this->message = $message__value;

        // ? Setting information from configuration
        $this->ACCOUNT = NEO_RED_CONFIG["ACCOUNT"];
        $this->USER = NEO_RED_CONFIG["USER"];
        $this->PASSWORD = NEO_RED_CONFIG["PASSWORD"];
        $this->MAILING_ID = NEO_RED_CONFIG["MAILING_ID"];
    }

    public function sendNotificationNeoRed()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'integracion.neored.mx/DelivraServices/TransactionalService.asmx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<?xml version="1.0" encoding="utf-8"?>
                                    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                        <soap12:Header>
                                            <Header xmlns="http://delivra.com/">
                                                <Username>' . $this->USER . '</Username>
                                                <Password>' . $this->PASSWORD . '</Password>
                                                <List>' . $this->ACCOUNT . '</List>
                                            </Header>
                                        </soap12:Header>
                                        <soap12:Body>
                                            <UpsertMembersToMailing xmlns="http://delivra.com/">
                                                <TransactionalMessageID>' . $this->MAILING_ID . '</TransactionalMessageID>
                                                <Members>
                                                    <diffgr:diffgram xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1">
                                                        <DocumentElement xmlns="">
                                                            <Member diffgr:id="Member1" msdata:rowOrder="0" diffgr:hasChanges="inserted">
                                                                <EmailAddress>' . $this->EmailAddress . '</EmailAddress>
                                                                <FirstName>' . $this->FirstName . ', ' . $this->message . '</FirstName>
                                                            </Member>
                                                        </DocumentElement>
                                                    </diffgr:diffgram>
                                                </Members>
                                            </UpsertMembersToMailing>
                                        </soap12:Body>
                                    </soap12:Envelope>',
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml; charset=utf-8',
                'SOAPAction: http://delivra.com/UpsertMembersToMailing'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response !== false ? "success" : "error";
    }
}
