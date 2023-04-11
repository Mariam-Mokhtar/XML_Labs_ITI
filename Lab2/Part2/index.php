<?php
session_start(); // start the session
$fileName = "employees.xml";
$fileContent = file_get_contents($fileName);
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML($fileContent);

$clearFlag = false;

$elementsLength = $doc->getElementsByTagName("employee")->length;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] === "insert") {
        // Create a new element
        $new_element = $doc->createElement('employee');

        //id
        $id_element = $doc->createElement('id');
        $id_element_text = $doc->createTextNode(uniqid());
        $id_element->appendChild($id_element_text);

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

        $new_element->append($id_element, $name_element, $email_element, $phone_element, $address_element);

        // Insert the new element into the document
        $root = $doc->documentElement;
        $root->appendChild($new_element);

        // Save
        $doc->save($fileName);
    }
    $index = $_SESSION["myIndex"];
    if ($_POST["action"] === "next" && $index < $elementsLength - 1) {
        $_SESSION["myIndex"] += 1;
    }

    if ($_POST["action"] === "prev" && $index > 0) {
        $_SESSION["myIndex"] -= 1;
    }

    if ($_POST["action"] === "clear") {
        $clearFlag = true;
    }
    if ($_POST["action"] === "delete") {
        $root = $doc->documentElement;
        $deleted_element = $root->childNodes[$_SESSION["myIndex"]];
        $root->removeChild($deleted_element);
        $doc->save($fileName);
        if ($_SESSION["myIndex"] > 0) {
            $_SESSION["myIndex"] -= 1;
        }
    }
    if ($_POST["action"] === "update") {
        $root = $doc->documentElement;
        $updated_element = $root->childNodes[$_SESSION["myIndex"]];
        $updated_element->childNodes[1]->nodeValue = $_POST['name'];
        $updated_element->childNodes[2]->nodeValue = $_POST['email'];
        $updated_element->childNodes[3]->nodeValue = $_POST['phone'];
        $updated_element->childNodes[4]->nodeValue = $_POST['address'];
        $doc->save($fileName);
    }
}

$index = $_SESSION["myIndex"]??0;
$employees = $doc->documentElement;
$employee = $employees->childNodes[$index];
$name = $employee->childNodes[1]->nodeValue;  // id @index 0
$email = $employee->childNodes[2]->nodeValue;
$phone = $employee->childNodes[3]->nodeValue;
$address = $employee->childNodes[4]->nodeValue;

if ($clearFlag) {
    $name = $email = $phone = $address = "";
    $clearFlag = false;
}




require_once("views/view.php");
