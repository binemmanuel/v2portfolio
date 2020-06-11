<?php
namespace model;

use portfolio\BaseModel;

use function portfolio\clean_data;

class Contact extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function send($data)
    {
        // Check if all requied data are set.
        if (
            !empty($data['email']) ||
            !empty($data['subject']) ||
            !empty($data['message'])
        ) {
            if (empty($data['email'])) {
                return [
                    'error' => true,
                    'message' => 'Please enter your email address.',
                    'type' => 'email',
                    'filled_data' => [
                        'email' => $data['email'], 
                        'subject' => $data['subject'], 
                        'message' => $data['message']
                    ]
                ];
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'error' => true,
                    'message' => 'Invalid email address.',
                    'type' => 'email',
                    'filled_data' => [
                        'email' => $data['email'], 
                        'subject' => $data['subject'], 
                        'message' => $data['message']
                    ]
                ];
            } elseif (empty($data['subject']))  {
                return [
                    'error' => true,
                    'message' => 'Please enter the subject of your message.',
                    'type' => 'subject',
                    'filled_data' => [
                        'email' => $data['email'], 
                        'subject' => $data['subject'],
                        'message' => $data['message']
                    ]
                ];
            } elseif (empty($data['message']))  {
                return [
                    'error' => true,
                    'message' => 'Please enter your message.',
                    'type' => 'message',
                    'filled_data' => [
                        'email' => $data['email'],
                        'subject' => $data['subject'],
                        'message' => $data['message']
                    ]
                ];
            }  else {
                $email = clean_data($data['email']);
                $subject = clean_data($data['subject']);
                $message = clean_data($data['message']);

                return [
                    'error' => false,
                    'message' => 'Successfully sent.',
                    'type' => null,
                    'filled_data'
                ];
            }
        } 
    }
}
