<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class FlashMessage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $sessionMessage;
    public $alertName;
    public $alert;

    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $possibleMessages = [
            'alert-success',
            'alert-error',
            'alert-info',
            'alert-danger',
            'alert-warning'
        ];

        $availableMessages = [];
        // dd($possibleMessages);
        foreach ($possibleMessages as $message) {

            if (Session::has($message)) {
                $this->alert = $message;
                $availableMessages[$message] = Session::get($message);
                $this->sessionMessage = $availableMessages[$message];

                $parts = explode('-', $message);
                $this->alertName = ucfirst(__("{$parts[1]}"));
            }
        }

        return view('components.flash-message');
    }
}
