<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Mail;
use Alert;
class assigntrainerL
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
    
       $event2= DB::table('trainers')->where('id',$event->trainerid)->first();
       
              $data=array("trainer"=>$event2->name,'password'=>strtolower($event2->name).$event2->id,'email'=>$event2->email);
               Mail::send('Mail.trainer', $data, function($message) use($data) {
               $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
                ('Welcome to F1school');
               $message->from('noreply@whitegarlic.in','F1School');
      });
    //   Alert::success('Success Title', 'Success Message');
        
    }
}
