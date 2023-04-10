<?php
session_start(); // start the session
$fileName = "employees.xml";
$fileContent = file_get_contents($fileName);
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML($fileContent);

$elementsLength = $doc->getElementsByTagName("employee")->length;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] === "insert") {
        // Create a new element
        $new_element = $doc->createElement('employee');

        //name
        $name_element = $doc->createElement('name');
        $name_element_text = $doc->createTextNode($_POST['name']);
        $name_element->appendChild($name_element_text);

        //email
        $email_element = $doc->createElement('email');
        $email_element_text = $doc->createTextNode($_POST['email']);
        $email_element->appendChild($email_element_text);

        //phone
        $phone_element = $doc->createElement('phone');
        $phone_element_text = $doc->createTextNode($_POST['phone']);
        $phone_element->appendChild($phone_element_text);

        //address
        $address_element = $doc->createElement('address');
        $address_element_text = $doc->createTextNode($_POST['address']);
        $address_element->appendChild($address_element_text);

        $new_element->append($name_element, $email_element, $phone_element, $address_element);

        // Insert the new element into the document
        $root = $doc->documentElement;
        $root->appendChild($new_element);

        // Save
        $doc->save($fileName);
    }
    $index = $_SESSION["myIndex"];
    if ($_POST["action"] === "next" && $index < $elementsLength-1) {
        $_SESSION["myIndex"] += 1;
    }

    if ($_POST["action"] === "prev" && $index > 0) {
        $_SESSION["myIndex"] -= 1;
    }
}



$index = $_SESSION["myIndex"];
$employees = $doc->documentElement;
$employee = $employees->childNodes[$index];
$name = $employee->childNodes[0]->nodeValue;
$email = $employee->childNodes[1]->nodeValue;
$phone = $employee->childNodes[2]->nodeValue;
$address = $employee->childNodes[3]->nodeValue;

require_once("views/view.php");
