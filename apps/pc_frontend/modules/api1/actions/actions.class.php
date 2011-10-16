<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * api1 actions.
 *
 * @package    OpenPNE
 * @subpackage api1
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class api1Actions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  public function executePost(sfWebRequest $r){
    $site = $r->getParameter("site");
    $from = $r->getParameter("from");
    $msg = $r->getParameter("msg");
    
    $queue_url = $sqs->create(sfConfig::get('cqc-p2c'));
//{"FROM":"mamoru@tejimaya.com","PRI":"3","TO":"tejima@tejimaya.com","MSG":"@tejima aaaaaaaaaaaaaaaaaaaaaa"}
    $sqs->send($queue_url, json_encode(array("FROM"=>"mamoru@tejimaya.com","PRI"=>"3","TO"=>"tejima@tejimaya.com","MSG"=>"@@@tejima HelloWorld")));
    return $this->renderText("DONE");
  }
}
