<html>
    <head>
        <style type="text/css">
            .resposta{
                background-color: #99ccff;
                padding: 10px;
                margin: 10px;
                overflow: auto;
            }            
        </style>
    </head>
    <body>
        <h1>PAC3</h1>
        <h2>Resposta:</h2>
        <?php
        require_once('xmlrpc.inc');
        require_once('xmlrpcs.inc');
        require_once('xmlrpc_wrappers.inc');

// construir un objecte que representi al servidor
        $servidor = new xmlrpc_client("/services/xmlrpc", "www.flickr.com", "80", "http");

// preparar el missatge
        $msgStruct = new xmlrpcval(
                        array(
                            "api_key" => new xmlrpcval("2ecf16a5f6c1fd01bc5cd9dca85e7b19", "string"),
                            "extras" => new xmlrpcval("tags,owner_name,url_m", "string"),
                            "per_page" => new xmlrpcval("12", "int"),
                        ), "struct");
        $message = new xmlrpcmsg("flickr.photos.getRecent", array($msgStruct));

// enviar el missatge
        $result = $servidor->send($message);

//processar la  resposta

        if (!$result) {
            print "<p>No es pot connectar al servidor.</p>";
        } elseif ($result->faultCode()) {
            switch ($result->faultCode()) {
                case 100:
                    print "<p>Invalid API Key.</p>";
                    break;
                case 105:
                    print "<p>Service currently unavaliable.</p>";
                    break;
                case 111:
                    print "<p>Format not found.</p>";
                    break;
                case 112:
                    print "<p>Method not found.</p>";
                    break;
                case 114:
                    print "<p>Invalid SOAP envelope.</p>";
                    break;
                case 115:
                    print "<p>Invalid XML-RPC Method Call.</p>";
                    break;
                case 116:
                    print "<p>Bad URL found.</p>";
                    break;
            }
        } else {
            // mostrar la resposta pregunta 1
            print ("<div class='resposta'><pre>");
            $text_response = str_replace("<", "&lt;", html_entity_decode($result->value()->serialize()));
            $start = strpos($text_response, "&lt;photos");
            $len = strlen($text_response);
            $text_response = substr($text_response, $start, $len - $start);
            $start = strripos($text_response, "&lt;/photos");
            $text_response = substr($text_response, 0, $start + 12);
            print ($text_response);
            print ("</pre></div>\n");

            // mostrar la resposta pregunta 2
            $text_xml = '<?xml version="1.0" encoding="UTF-8"?>
                '.str_replace("&lt;", "<", $text_response);
            $xml = new DOMDocument();
            $xsl = new DOMDocument();
            $xml->loadXML($text_xml);
            $xsl->load("PAC3.xsl");
            $xslt = new XSLTProcessor();
            $xslt->importStylesheet($xsl);
            // print
            print($xslt->transformToXml($xml));
        }
        ?>

    </body>
</html>
