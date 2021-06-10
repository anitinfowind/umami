<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail,Str,DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
	/**
     * @param array $mailData
     * @param string $filePath
     * @param string $subject
     * @return mixed
     */
    public function sendMail(array $mailData, string $filePath, string $subject)
    {
		
        if(isset($mailData['emailTo']) && $mailData['emailTo']) {
            $to = env('MAIL_FROM');
            $from = $mailData['emailFrom'];
        } else {
            $to = $mailData['email'];
            $from = env('MAIL_FROM');
        }
		
        return Mail::send($filePath,
            $mailData,
            function ($message) use ($mailData, $subject, $to, $from) {
                $message->to($to)
                    ->subject($subject)
                    ->from($from, env('APP_NAME'));
            });
    }

    /**
     * @param $title
     * @param string $fieldName
     * @param $tableName
     * @param int $limit
     * @return false|string
     */
    public function getSlug($title, $fieldName = '', $tableName, $limit = 30){
        $slug 		=	substr(Str::slug($title),0 ,$limit);
        $slug 		=	Str::slug($title);
        $DB 		= 	DB::table($tableName);
        $slugCount 	= 	count( $DB->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get() );

        return ($slugCount > 0) ? $slug."-".$slugCount: $slug;
    }
}


