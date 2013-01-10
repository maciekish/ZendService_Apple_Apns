<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage Apns
 */

namespace ZendService\Apple\Apns\Client;

use ZendService\Apple\Exception;
use ZendService\Apple\Apns\Response\Feedback as FeedbackResponse;

/**
 * Apple Push Notification Client
 * This class allows the ability to send out
 * messages through apple push notification service
 *
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage Apns
 */
class Feedback extends AbstractClient
{
    /**
     * APNS URI Constants
     * @var int
     */
    const SANDBOX_URI = 0;
    const PRODUCTION_URI = 1;

    /**
     * APNS URIs
     * @var array
     */
    protected $uris = array(
        'ssl://feedback.sandbox.push.apple.com:2196',
        'ssl://feedback.push.apple.com:2196'
    );

    /**
     * Get Feedback
     *
     * @return array of ZendService\Apple\Apns\Response\Feedback
     */
    public function getFeedback()
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $tokens = array();
        while ($token = $this->read(38)) {
            if (strlen($token) < 38) {
                continue;
            }
            $tokens[] = new FeedbackResponse($token);
        }   
        return $tokens;
    }
}