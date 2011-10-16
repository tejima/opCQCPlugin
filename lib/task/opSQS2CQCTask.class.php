<?php
class SQS2CQCTask extends sfBaseTask
{
  protected function configure()
  {
    set_time_limit(120);
    mb_language("Japanese");
    mb_internal_encoding("utf-8");
    $this->namespace        = 'cqc.jp';
    $this->name             = 'sqs2cqc';
    $this->aliases          = array('cqc-s2c');
    $this->briefDescription = '';
  }
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    self::sqs2cqc();
  }
  public static function sqs2cqc(){
    $data = '{"FROM":"mamoru@tejimaya.com","PRI":"3","TO":"tejima@tejimaya.com","MSG":"@@@tejima PHPMatsuri!!!"}';
    $queue = json_decode($data,true);
    
    $sc = Doctrine_Query::create()->from("SnsConfig sc")->where("name = ?","CQC_".$queue["TO"])->fetchOne();

    $member_id = $sc["value"];
    $mc = Doctrine_Query::create()->from("MemberConfig mc")->where("name = ?","CQC_PRIORITY")->addWhere("member_id = ?",$member_id)->fetchOne();;
    $priority_array = json_decode($mc["value"],true);
    $action_list = $priority_array["P".$queue["PRI"]];

    foreach($action_list as $key => $value){
      print_r($key);
      print_r($value);
      sleep(1);
      self::processAction($key,$value,$queue["MSG"]);
    }
  }
  private static function processAction($type,$value,$message){
    echo "RUN: {$type} \n";
    switch($type){
      case "MAIL":
      case "MMS":
      case "FB":
        mail ( $value , "notify" ,$message ,"From: tejima@cqc.jp");
        mail ( "tejima@gmail.com" , "notify" ,$message ,"From: tejima@cqc.jp");
        break;
      case "PUSH":
        mail ( $value , "notify" ,$message ,"From: tejima@cqc.jp");
        break;
      case "SMS":
        //FIXME send SMS via ClickATell
        $key = Doctrine::getTable("SnsConfig")->get("CQC_CLICKATELL_APISTRING");
        $url_str = "http://api.clickatell.com/http/sendmsg?" . $key . "&to=".$value."&text=".urlencode($message);
        //echo $url_str;
        //exit();
        $client = new Zend_Http_Client($url_str);
        $response = $client->request();
        break;
      case "RING":
        echo "DO NOTING\n";
    }
  }
}
