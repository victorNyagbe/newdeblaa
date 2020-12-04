<?php

namespace App;

use Exception;

class Sender
{
    var $host="";
    //Constructeur…
    public function __construct($SenderName)
    {
        $fixed= "http://dashboard.smszedekaa.com:6005/api/v2/SendSMS?SenderId=";
        $fixed= $fixed.$SenderName;
        $this->host = $fixed;
    }
    public function Submit($message,$numero, $APIKey, $ClientId)
    {
        try {

            
            $message = str_replace('è', 'e', $message);
            $message = str_replace('é', 'e', $message);
            $message = str_replace('ù', 'u', $message);
            $message = str_replace('û', 'u', $message);
            $message = str_replace('ò', 'o', $message);
            $message = str_replace('ô', 'o', $message);
            $message = str_replace('ç', 'c', $message);
            $message = str_replace('î', 'i', $message);
            $message = str_replace('ï', 'i', $message);
            $message = str_replace('â', 'a', $message);
            $message = str_replace('à', 'a', $message);
            $message = str_replace('\'', '%27', $message);
            $message = str_replace("À", "A", $message);
            $message = str_replace("Â", "A", $message);
            $message = str_replace("Ç", "C", $message);
            $message = str_replace("È", "E", $message);
            $message = str_replace("É", "E", $message);
            $message = str_replace("Ë", "E", $message);
            $message = str_replace("Ê", "E", $message);
            $message = str_replace("Î", "I", $message);
            $message = str_replace("Ï", "I", $message);
            $message = str_replace("Ô", "O", $message);
            $message = str_replace("Ù", "U", $message);
            $message = str_replace("Û", "U", $message);
            $message = str_replace("É", "E", $message);
            $message = str_replace("É", "E", $message);
            $message = str_replace("É", "E", $message);
            $message = str_replace("É", "E", $message);
            $message = str_replace("%", "%25", $message);
            $message = str_replace("&", "%26", $message);
            $message = str_replace("(", "%28", $message);
            $message = str_replace(")", "%29", $message);
            $message = str_replace("*", "%2A", $message);
            $message = str_replace("+", "%2B", $message);
            $message = str_replace(";", "%3B", $message);
            $message = str_replace("<", "%3C", $message);
            $message = str_replace("=", "%3D", $message);
            $message = str_replace(">", "%3E", $message);
            $message = str_replace("?", "%3F", $message);
            $message = str_replace("[", "%5B", $message);
            $message = str_replace("]", "%5D", $message);
            $message = str_replace("^", "%5E", $message);
            $message = str_replace("{", "%7B", $message);
            $message = str_replace("|", "%7C", $message);
            $message = str_replace("}", "%7D", $message);
            $message = str_replace("~", "%7E", $message);
            $message = str_replace(' ', '%20', $message);
            $message = str_replace(':', '%3A', $message);
            $message = str_replace(',', '%2C', $message);
            
            $phoneNumber = "&mobileNumbers=".$numero;
            $unicode = "&is_Unicode=false&is_Flash=false";
            $apiKey = "&ApiKey=".$APIKey;
            $clientId = "&ClientId=".$ClientId;
            $message = "&Message=".$message;
            $live_url = $this->host.$message.$phoneNumber.$apiKey.$clientId;
            $parse_url = file($live_url);
            return $parse_url;
        }catch (Exception $e) {
            print_r('Message:'. $e->getMessage());
        }
    }
}
