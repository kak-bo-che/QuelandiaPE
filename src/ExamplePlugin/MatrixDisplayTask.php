<?php

namespace ExamplePlugin;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;

class MatrixDisplayTask extends AsyncTask{
  public $endpointUrl;
  public $elementDescription;

  public function __construct($endpointUrl, $elementDescription){
     $this->endpointUrl = $endpointUrl;
     $this->elementDescription = $elementDescription;
  }

	public function onRun(){
    // Utils::postURL($this->endpointUrl, $this->elementDescription);
    $this->displayBlock($this->endpointUrl, $this->elementDescription);
	}

  public function displayBlock($endpointUrl, $elementDescription){
    $blockName = strtolower (join("_", explode(" ", $elementDescription)));
    $data = array("block" => $blockName);
    $data_string = json_encode($data);
    $ch = curl_init($endpointUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    curl_close($ch);
  }
}
