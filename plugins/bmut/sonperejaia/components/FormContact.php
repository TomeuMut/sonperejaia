<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Contact;
use Cms\Classes\ComponentBase;
use October\Rain\Support\Facades\Flash;

/**
 * FormContact Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class FormContact extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'FormContact Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }
    function onSend() {

        // Collect input
        $fname = post('name');
        $email = post('email');        
        $phone = post('phone');
        $msg = post('text');
        
        $contact = Contact::create([ 'name'=>$fname ,'email' => $email, 'asunto' => $msg, 'phone' => $phone ]);
        
        Mail::send('maximilian::mail.contact', $contact->toArray() ,function ($message) {
                $message->from('info@maximilianparquet.com', 'Maximilian Parquet');
                $message->to('info@maximilianparquet.com', 'Maximilian Parquet');
            }
        );

        Flash::success('El formulario ha sido enviado con exito');

        }
        
}
