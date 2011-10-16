<?php

/**
 * cqc actions.
 *
 * @package    OpenPNE
 * @subpackage cqc
 * @author     Your name here
 */
class cqcActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  public function executeLoadconfig(sfWebRequest $r){
    $id = $this->getUser()->getMember()->getId();
    $member = Doctrine::getTable("member")->find($id);
    $text = $member->getConfig("CQC_PRIORITY");
//$text = '{"P1":{"MMS":"mamoru.tejima.0422@softbank.ne.jp"},"P3":{"PUSH":"1d21fa.1567547@push.boxcar.io","FB":"tejima@facebook.com"},"P1":{"SMS":"818040600334","RING":"08040600334"}}';

    return $this->renderText($text);
  }
  public function executeUpdateConfig(sfWebRequest $r){
    $value = $r->getParameter("value","NO_VALUE");
    $id = $this->getUser()->getMember()->getId();
    $member = Doctrine::getTable("member")->find($id);
    $member->setConfig("CQC_PRIORITY",$value);
    //$member->setConfig("CQC_PRIORITY","aaaaaaaaaaaaaaaaaaaaaaa");


    $member->save();
    $text = $member->getConfig("CQC_PRIORITY");
    
    return $this->renderText($text);
  }
}
