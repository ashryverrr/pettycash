<?php
/* Create a class for your webservice structure, in this case: Contact */
class Contact {
    function Contact($id, $name) 
    {
        $this->id = $id;
        $this->name = $name;
    }
}
libxml_disable_entity_loader(false);
/* Initialize webservice with your WSDL */
$client = new SoapClient("Service1.asmx?wsdl");

$wsdl = "Service1.asmx";
echo file_get_contents($wsdl);
die();

/* Fill your Contact Object */
$contact = new Contact(100, "John");

/* Set your parameters for the request */
$params = array(
  "Contact" => $contact,
  "description" => "Barrel of Oil",
  "amount" => 500,
);

/* Invoke webservice method with your parameters, in this case: Function1 */
$response = $client->__soapCall("Function1", array($params));

/* Print webservice response */
var_dump($response);

?>