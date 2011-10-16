<?php
class TestTask extends sfBaseTask
{
  protected function configure()
  {
    set_time_limit(120);
    mb_language("Japanese");
    mb_internal_encoding("utf-8");
    $this->namespace        = 'cqc.jp';
    $this->name             = 'Test';
    $this->aliases          = array('cqc-test');
    $this->briefDescription = '';
  }
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    self::setMemberConfig();
    //self::printQueue();
  }
  public static function setMemberConfig(){
    $member = Doctrine::getTable("Member")->find(1);
/*
    $result = array(
      "P1"=>array("P_MAIL"=>"mamoru.tejima.0422@softbank.ne.jp"),
      "P2"=>array("SMS"=>"818040600334","PUSH"=>"1d21fa.1567547@push.boxcar.io"),
      "P3"=>array("RING"=>"08040600334"),
    );
    $member->setConfig("CQC_PRIORITY",json_encode($result));
*/
    $member->setConfig("pc_address","tejima@tejimaya.com");
  }
  public static function printQueue(){
    $format = array("FROM"=>"mamoru@tejimaya.com","PRI"=>"3","TO"=>"tejima@tejimaya.com","MSG"=>"@tejima aaaaaaaaaaaaaaaaaaaaaa");
    echo json_encode($format);
    echo "\n";
  }
}
